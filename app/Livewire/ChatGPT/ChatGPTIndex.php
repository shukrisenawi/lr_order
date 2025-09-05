<?php

namespace App\Livewire\ChatGPT;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Services\DatabaseQueryService;

class ChatGPTIndex extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public $isSending = false; // New property to manage send button state
    public $errorMessage = '';
    public $selectedModel = 'gemini/gemini-2.0-flash-lite';
    public $embedded = false;
    public $uploadedImage;
    public $systemMessage = '';
    public $showSystemMessageModal = false;

    protected $databaseQueryService;
    protected $listeners = ['modelChanged' => 'handleModelChange', 'syncModelFromFloatingChat' => 'syncModelFromFloatingChat', 'syncSystemMessageFromChatGPT' => 'syncSystemMessageFromFloatingChat', 'clearChatOnLogout' => 'clearChatOnLogout'];

    public function __construct()
    {
        $this->databaseQueryService = new DatabaseQueryService();
    }

    public function handleModelChange($model)
    {
        $this->selectedModel = $model;
        session(['chat_selected_model' => $model]);
    }

    public function updatedSelectedModel($value)
    {
        session(['chat_selected_model' => $value]);

        // Emit event to sync with FloatingChat component if it exists on the page
        $this->dispatch('syncModelFromChatGPT', $value);
    }

    public function syncModelFromFloatingChat($model)
    {
        $this->selectedModel = $model;
        session(['chat_selected_model' => $model]);
    }

    public function syncSystemMessageFromFloatingChat($message)
    {
        $this->systemMessage = $message;
        session(['chat_system_message' => $message]);
    }

    public function mount($embedded = false, $selectedModel = null)
    {
        $this->embedded = $embedded;

        if ($selectedModel) {
            $this->selectedModel = $selectedModel;
        } elseif (session()->has('chat_selected_model')) {
            $this->selectedModel = session('chat_selected_model');
        }

        // Set default system message
        $currentTime = now()->setTimezone('Asia/Kuala_Lumpur')->format('l, d F Y H:i:s T');
        $this->systemMessage = session('chat_system_message', 'You are a helpful AI assistant with access to a business management database. ' .
            'Respond in Malay language unless specifically asked otherwise. ' .
            'IMPORTANT: Current date and time information: ' . $currentTime . '. ' .
            'You MUST use this current time information to answer questions about time, date, or schedule. ' .
            'When asked "pukul berapa", "jam berapa", "tarikh apa", or similar time questions, you MUST provide the current time from the information above. ' .
            'Do NOT say you don\'t have access to current time - you DO have access to it. ' .
            'You have access to the following database tables: ' . $this->getDatabaseContext() . '. ' .
            'If the user asks about data, provide helpful analysis and insights based on the available information. ' .
            'Always be helpful, accurate, and provide actionable information.');

        // Load messages from session if exists, otherwise initialize with welcome message
        if (session()->has('chatgpt_messages')) {
            $this->messages = session('chatgpt_messages');
        } else {
            $welcomeMessage = $this->embedded
                ? 'Halo! Saya AI assistant dengan akses database. Tanya saya tentang data dalam sistem!'
                : 'Halo! Saya adalah asisten AI yang boleh membantu anda dengan soalan tentang data dalam sistem. Saya boleh memberikan maklumat tentang pelanggan, invois, produk, dan banyak lagi. Apa yang boleh saya bantu hari ini?';

            $this->messages = [
                [
                    'role' => 'assistant',
                    'content' => $welcomeMessage . "\n\n**Contoh format markdown:**\n- *Italic text*\n- **Bold text**\n- `Code inline`\n\n```php\necho 'Hello World';\n```",
                    'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A'),
                    'model' => $this->selectedModel
                ]
            ];
            // Save initial messages to session
            session(['chatgpt_messages' => $this->messages]);
        }
    }

    protected $rules = [
        'newMessage' => 'required|string|max:2000',
        'uploadedImage' => 'nullable|image|max:2048',
    ];

    protected $messages_validation = [
        'newMessage.required' => 'Sila masukkan mesej.',
        'newMessage.string' => 'Mesej mestilah teks.',
        'newMessage.max' => 'Mesej maksimum 2000 aksara.',
        'uploadedImage.image' => 'Fail yang dimuat naik mestilah imej.',
        'uploadedImage.max' => 'Saiz imej maksimum 2MB.',
    ];

    public function sendMessage()
    {
        // Trim the message first
        $this->newMessage = trim($this->newMessage);

        // Validate the message
        $this->validate();

        // Prevent sending if already in the process of sending
        if ($this->isSending) {
            return; // Exit if already sending
        }

        // Check if message is empty after trimming
        if (empty($this->newMessage)) {
            return; // Don't send empty messages
        }

        // Check for duplicate messages before adding
        if (!in_array($this->newMessage, array_column($this->messages, 'content'))) {
            $userMessage = $this->newMessage;

            // Prepare content for API
            $content = $userMessage;

            if ($this->uploadedImage && $this->supportsVision($this->selectedModel)) {
                $imageData = base64_encode(file_get_contents($this->uploadedImage->getRealPath()));
                $mimeType = $this->uploadedImage->getMimeType();
                $content = [
                    ['type' => 'text', 'text' => $userMessage],
                    ['type' => 'image_url', 'image_url' => ['url' => 'data:' . $mimeType . ';base64,' . $imageData]]
                ];
            } elseif ($this->uploadedImage && !$this->supportsVision($this->selectedModel)) {
                $this->setErrorMessage('Model yang dipilih tidak menyokong input imej.');
                return;
            }

            $this->messages[] = [
                'role' => 'user',
                'content' => $content,
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A'),
                'model' => $this->selectedModel
            ];

            // Save messages to session
            session(['chatgpt_messages' => $this->messages]);

            // Auto-scroll to bottom after adding user message
            $this->dispatch('scroll-to-bottom');

            $this->newMessage = ''; // Clear message input
            $this->uploadedImage = null; // Clear uploaded image
            $this->isSending = true; // Set sending state
            $this->isTyping = true; // Indicate that typing has started
            $this->errorMessage = '';

            // Call AI API directly after setting sending state
            $this->callAIAPI($content);
        }
    }

    private function supportsVision($model)
    {
        $visionModels = [
            'gpt-4o',
            'gpt-4o-mini',
            'gpt-4.1',
            'gpt-4.1-mini',
            'gpt-4.1-nano',
            'gpt-5',
            'gpt-5-chat',
            'gpt-5-mini',
            'gpt-5-nano',
            'claude-3-5-haiku',
            'claude-3-5-sonnet',
            'claude-3-7-sonnet',
            'claude-sonnet-4',
            'gemini/gemini-2.0-flash',
            'gemini/gemini-2.0-flash-lite',
            'gemini/gemini-2.5-flash',
            'gemini/gemini-2.5-flash-lite',
            'gemini/gemini-2.5-pro'
        ];
        return in_array($model, $visionModels) || str_contains($model, 'gpt-4') || str_contains($model, 'claude') || str_contains($model, 'gemini');
    }

    private function callAIAPI($content)
    {
        try {
            // Extract text for database query
            $textForQuery = is_array($content) ? $content[0]['text'] : $content;

            // Check if the user is asking about data/database queries
            $databaseResult = $this->handleDatabaseQuery($textForQuery);

            if ($databaseResult !== null) {
                // If we have database results, include them in the AI context
                $enhancedMessage = $textForQuery . "\n\nMaklumat dari database:\n" . $databaseResult;
            } else {
                $enhancedMessage = $textForQuery;
            }

            // Get database schema information for context
            $schemaInfo = $this->getDatabaseContext();

            // Prepare messages for API
            $messages = [
                [
                    'role' => 'system',
                    'content' => $this->systemMessage . ' ' .
                        'IMPORTANT: When users ask questions about data from the database, you should provide the information directly if it has been retrieved from the database. ' .
                        'If database results are provided in the conversation, use them to give complete and accurate answers. ' .
                        'For questions about data quantities or lists, provide the actual data when available. ' .
                        'Only say you cannot provide information if no database results are available.'
                ]
            ];

            // Add conversation history (excluding the current user message)
            foreach ($this->messages as $index => $msg) {
                if ($msg['role'] === 'user' && $index === count($this->messages) - 1) {
                    // Skip the current user message, will add later
                } else {
                    $messages[] = [
                        'role' => $msg['role'],
                        'content' => $msg['content']
                    ];
                }
            }

            // Add the enhanced user message (with database results if available)
            $userContent = is_array($content) ? $content : $enhancedMessage;
            $messages[] = [
                'role' => 'user',
                'content' => $userContent
            ];

            // Make API call to SumoPod AI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.sumopod.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.sumopod.base_url') . '/chat/completions', [
                'model' => $this->selectedModel,
                'messages' => $messages,
                'max_tokens' => 1000,
                'temperature' => 0.7
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak dapat mendapatkan respons dari AI.';

                $this->addAssistantMessage($aiResponse);
            } else {
                $this->setErrorMessage('Gagal mendapatkan respons dari AI. Sila cuba lagi.');
            }
        } catch (\Exception $e) {
            $this->setErrorMessage('Ralat: ' . $e->getMessage());
        } finally {
            $this->isSending = false; // Reset sending state after response
        }
    }

    private function handleDatabaseQuery($userMessage)
    {
        try {
            // Check for simple count queries first
            $countResult = $this->handleSimpleCountQuery($userMessage);
            if ($countResult !== null) {
                return $countResult;
            }

            // Check for invoice search
            $invoiceSearch = $this->detectInvoiceSearch($userMessage);
            if ($invoiceSearch) {
                // Verify if invoice exists in database
                $invoiceExists = $this->verifyInvoiceExists($invoiceSearch);

                if ($invoiceExists) {
                    $this->redirectToInvoiceSearch($invoiceSearch);
                    return null; // Don't return message since we're redirecting
                } else {
                    return "Maaf, invoice nombor " . $invoiceSearch . " tidak ditemui dalam database sistem. Sila pastikan nombor invoice adalah betul.";
                }
            }

            // Check if this looks like a database query using DatabaseQueryService
            $queryResult = $this->databaseQueryService->generateQueryFromNaturalLanguage($userMessage);

            if ($queryResult) {
                $result = $this->databaseQueryService->executeSafeQuery(
                    $queryResult['sql'],
                    $queryResult['bindings'] ?? []
                );

                return $this->databaseQueryService->formatQueryResult($result, $queryResult['description']);
            }

            return null;
        } catch (\Exception $e) {
            return "Ralat semasa mengakses database: " . $e->getMessage();
        }
    }


    private function detectInvoiceSearch($message)
    {
        $message = strtolower($message);

        // Patterns to detect invoice search requests
        $patterns = [
            '/(?:cari|tolong cari|find|search)\s+(?:nombor\s+)?invoice\s+(\w+)/i',
            '/(?:cari|tolong cari|find|search)\s+(\w+)\s+(?:invoice|invois)/i',
            '/invoice\s+(?:nombor\s+)?(\w+)/i',
            '/nombor\s+invoice\s+(\w+)/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                return trim($matches[1]);
            }
        }

        return null;
    }

    private function handleSimpleCountQuery($message)
    {
        $message = strtolower($message);

        // Patterns for count queries
        $patterns = [
            '/(?:berapa\s+)?(?:banyak|jumlah|ada)\s+invoice/i',
            '/(?:berapa\s+)?(?:banyak|jumlah|ada)\s+inv?ois/i',
            '/invoice\s+(?:berapa|ada)\s+(?:banyak|jumlah)/i',
            '/(?:berapa\s+)?(?:banyak|jumlah)\s+(?:data\s+)?invoice/i',
            '/total\s+invoice/i',
            '/jumlah\s+keseluruhan\s+invoice/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                try {
                    $count = \App\Models\Invoice::where('bisnes_id', session('selected_bisnes_id'))->count();
                    return "Berdasarkan database, terdapat sejumlah {$count} invoice dalam sistem.";
                } catch (\Exception $e) {
                    return "Ralat semasa mengakses database: " . $e->getMessage();
                }
            }
        }

        return null;
    }

    private function verifyInvoiceExists($invoiceNumber)
    {
        try {
            // Check if invoice exists in database
            $invoice = \App\Models\Invoice::where('invoice_no', $invoiceNumber)
                ->where('bisnes_id', session('selected_bisnes_id'))
                ->first();

            return $invoice ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function redirectToInvoiceSearch($invoiceNumber)
    {
        // Emit event to redirect using JavaScript
        $this->dispatch('redirect-to-invoice', url: route('invoice.index', ['search' => $invoiceNumber]));
    }

    private function getDatabaseContext()
    {
        $schema = $this->databaseQueryService->getDatabaseSchema();
        $tableNames = array_keys($schema);

        $context = implode(', ', $tableNames);
        $context .= '. Anda boleh menanya tentang: bilangan rekod, senarai data, carian spesifik, dan statistik dari jadual-jadual ini.';

        return $context;
    }

    public function getDatabaseSummary()
    {
        try {
            $summary = $this->databaseQueryService->getTableSummary();
            $response = "Ringkasan Database:\n\n";

            foreach ($summary as $table => $info) {
                $response .= "**$table**: {$info['description']}\n";
                $response .= "- Jumlah rekod: {$info['record_count']}\n\n";
            }

            return $response;
        } catch (\Exception $e) {
            return "Ralat mendapatkan ringkasan database: " . $e->getMessage();
        }
    }

    public function addAssistantMessage($message)
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $message,
            'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A'),
            'model' => $this->selectedModel
        ];
        $this->isTyping = false;

        // Save messages to session
        session(['chatgpt_messages' => $this->messages]);

        // Auto-scroll to bottom after adding message
        $this->dispatch('scroll-to-bottom');
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
        $this->isTyping = false;
    }

    public function clearChat()
    {
        $this->messages = [
            [
                'role' => 'assistant',
                'content' => 'Halo! Saya adalah asisten AI yang siap membantu anda. Apa yang boleh saya bantu hari ini?',
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A'),
                'model' => $this->selectedModel
            ]
        ];
        $this->errorMessage = '';

        // Clear messages from session and save welcome message
        session(['chatgpt_messages' => $this->messages]);
    }

    public function openSystemMessageModal()
    {
        $this->showSystemMessageModal = true;
    }

    public function closeSystemMessageModal()
    {
        $this->showSystemMessageModal = false;
    }

    public function updateSystemMessage()
    {
        session(['chat_system_message' => $this->systemMessage]);
        $this->closeSystemMessageModal();
        session()->flash('message', 'System message telah dikemas kini.');

        // Emit event to sync with FloatingChat component if it exists on the page
        $this->dispatch('syncSystemMessageFromChatGPT', $this->systemMessage);
    }

    public function clearChatOnLogout()
    {
        // Clear all chat-related session data on logout
        session()->forget(['chatgpt_messages']);
        $this->messages = [];
    }

    public function checkTypingStatus()
    {
        // This method is called by wire:poll to ensure reactivity
        return $this->isTyping;
    }

    public function getAvailableModels()
    {
        return [
            'claude-3-5-haiku' => 'Claude 3.5 Haiku - $1.00/$5.00',
            'claude-3-5-sonnet' => 'Claude 3.5 Sonnet - $3.00/$15.00',
            'claude-3-7-sonnet' => 'Claude 3.7 Sonnet - $3.00/$15.00',
            'deepseek/deepseek-chat' => 'DeepSeek Chat - $0.27/$1.10',
            'deepseek/deepseek-reasoner' => 'DeepSeek Reasoner - $0.55/$2.19',
            'gemini/gemini-2.0-flash' => 'Gemini 2.0 Flash - $0.10/$0.40',
            'gemini/gemini-2.0-flash-lite' => 'Gemini 2.0 Flash Lite - $0.07/$0.30',
            'gemini/gemini-2.5-flash' => 'Gemini 2.5 Flash - $0.30/$2.50',
            'gemini/gemini-2.5-flash-lite' => 'Gemini 2.5 Flash Lite - $0.10/$0.40',
            'gemini/gemini-2.5-pro' => 'Gemini 2.5 Pro - $1.25/$10.00',
            'gpt-4.1' => 'GPT-4.1 - $2.00/$8.00',
            'gpt-4.1-mini' => 'GPT-4.1 Mini - $0.40/$1.60',
            'gpt-4.1-nano' => 'GPT-4.1 Nano - $0.10/$0.40',
            'gpt-4o' => 'GPT-4o - $2.50/$10.00',
            'gpt-4o-mini' => 'GPT-4o Mini - $0.15/$0.60',
            'gpt-4o-mini-transcribe' => 'GPT-4o Mini Transcribe - $1.25/$5.00',
            'gpt-4o-mini-tts' => 'GPT-4o Mini TTS - $2.50/$10.00',
            'gpt-4o-transcribe' => 'GPT-4o Transcribe - $2.50/$10.00',
            'gpt-5' => 'GPT-5 - $1.25/$10.00',
            'gpt-5-chat' => 'GPT-5 Chat - $1.25/$10.00',
            'gpt-5-mini' => 'GPT-5 Mini - $0.25/$2.00',
            'gpt-5-nano' => 'GPT-5 Nano - $0.05/$0.40',
            'gpt-image-1' => 'GPT Image 1 - $10.00/$40.00',
            'text-embedding-3-large' => 'Text Embedding 3 Large - $0.13/$0.00',
            'text-embedding-3-small' => 'Text Embedding 3 Small - $0.02/$0.00',
            'text-embedding-ada-002' => 'Text Embedding Ada 002 - $0.10/$0.00',
            'text-embedding-ada-002-v2' => 'Text Embedding Ada 002 v2 - $0.10/$0.00',
            'whisper-1' => 'Whisper 1 - $0.00/$0.00',
            'claude-sonnet-4' => 'Claude Sonnet 4 - $3.00/$15.00',
            'openrouter/qwen/qwen3-coder' => 'Qwen 3 Coder - $1.00/$5.00'
        ];
    }

    public function render()
    {
        return view('livewire.chat-gpt.chat-gpt-index', [
            'availableModels' => $this->getAvailableModels()
        ]);
    }
}
