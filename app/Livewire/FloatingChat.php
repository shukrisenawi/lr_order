<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Services\DatabaseQueryService;

class FloatingChat extends Component
{
    public $isOpen = false;
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public $isSending = false;
    public $errorMessage = '';
    public $selectedModel = 'gemini/gemini-2.0-flash-lite';
    public $systemMessage = '';
    public $showSystemMessageModal = false;

    protected $listeners = ['openChat' => 'openChat', 'modelChanged' => 'handleModelChange', 'syncModelFromChatGPT' => 'syncModelFromChatGPT', 'syncSystemMessageFromFloatingChat' => 'syncSystemMessageFromChatGPT'];
    protected $databaseQueryService;

    public function __construct()
    {
        $this->databaseQueryService = new DatabaseQueryService();
    }

    public function mount()
    {
        // Load selected model from ChatGPT session if exists, otherwise use floating chat session
        if (session()->has('chat_selected_model')) {
            $this->selectedModel = session('chat_selected_model');
        } elseif (session()->has('floating_chat_selected_model')) {
            $this->selectedModel = session('floating_chat_selected_model');
        }

        // Load system message from ChatGPT session
        $this->systemMessage = session('chat_system_message', 'You are a helpful AI assistant with access to a business management database. ' .
            'Respond in Malay language unless specifically asked otherwise. ' .
            'You have access to the following database tables: ' . $this->getDatabaseContext() . '. ' .
            'If the user asks about data, provide helpful analysis and insights based on the available information. ' .
            'Always be helpful, accurate, and provide actionable information.');

        // Initialize with welcome message
        $this->messages = [
            [
                'role' => 'assistant',
                'content' => 'Halo! Saya AI assistant dengan akses database. Saya boleh membantu mencari invoice dan data lain. Apa yang boleh saya bantu?',
                'timestamp' => now()->format('H:i')
            ]
        ];
    }

    public function openChat()
    {
        $this->isOpen = true;
    }

    public function closeChat()
    {
        $this->isOpen = false;
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function handleModelChange($model)
    {
        $this->selectedModel = $model;
    }

    public function syncModelFromChatGPT($model)
    {
        $this->selectedModel = $model;
        session(['floating_chat_selected_model' => $model]);
        session(['chat_selected_model' => $model]);
    }

    public function syncSystemMessageFromChatGPT($message)
    {
        $this->systemMessage = $message;
        session(['chat_system_message' => $message]);
    }

    public function updatedSelectedModel($value)
    {
        session(['floating_chat_selected_model' => $value]);
        session(['chat_selected_model' => $value]); // Sync with ChatGPT session

        // Emit event to sync with ChatGPT component if it exists on the page
        $this->dispatch('syncModelFromFloatingChat', $value);
    }

    public function sendMessage()
    {
        $this->newMessage = trim($this->newMessage);

        if (empty($this->newMessage)) {
            return;
        }

        if ($this->isSending) {
            return;
        }

        $userMessage = $this->newMessage;

        $this->messages[] = [
            'role' => 'user',
            'content' => $userMessage,
            'timestamp' => now()->format('H:i')
        ];

        $this->newMessage = '';
        $this->isSending = true;
        $this->isTyping = true;
        $this->errorMessage = '';

        // Check for simple count queries first
        $countResult = $this->handleSimpleCountQuery($userMessage);
        if ($countResult !== null) {
            $this->addAssistantMessage($countResult);
            return;
        }

        // Check for invoice search
        $invoiceSearch = $this->detectInvoiceSearch($userMessage);
        if ($invoiceSearch) {
            // Verify if invoice exists in database
            $invoiceExists = $this->verifyInvoiceExists($invoiceSearch);

            if ($invoiceExists) {
                $this->redirectToInvoiceSearch($invoiceSearch);
                $this->addAssistantMessage("Invoice nombor " . $invoiceSearch . " ditemui! Saya sedang mengarahkan anda ke halaman invoice.");
            } else {
                $this->addAssistantMessage("Maaf, invoice nombor " . $invoiceSearch . " tidak ditemui dalam database sistem. Sila pastikan nombor invoice adalah betul.");
            }
            return;
        }

        // Check for database queries
        $databaseResult = $this->handleDatabaseQuery($userMessage);
        if ($databaseResult !== null) {
            $this->addAssistantMessage($databaseResult);
            return;
        }

        // Call AI API for other queries
        $this->callAIAPI($userMessage);
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

    private function callAIAPI($content)
    {
        try {
            // Get database schema information for context
            $schemaInfo = $this->getDatabaseContext();

            // Prepare messages for API
            $messages = [
                [
                    'role' => 'system',
                    'content' => $this->systemMessage . ' ' .
                        'CRITICAL: For ANY question about data quantities, counts, or existence, you MUST tell the user that you cannot provide that information directly and they should ask specific questions that will be processed by the database system. ' .
                        'NEVER make up numbers or statistics. If asked "how many invoices" or similar count questions, respond by saying you need to check the database and the system will provide the accurate count. ' .
                        'Only provide information that has been verified through database queries. For any unverified information, direct the user to ask specific questions.'
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

            // Add the current user message
            $messages[] = [
                'role' => 'user',
                'content' => $content
            ];

            // Make API call to SumoPod AI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.sumopod.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.sumopod.base_url') . '/chat/completions', [
                'model' => $this->selectedModel,
                'messages' => $messages,
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak dapat mendapatkan respons dari AI.';

                $this->addAssistantMessage($aiResponse);
            } else {
                $this->addAssistantMessage('Maaf, gagal mendapatkan respons dari AI. Sila cuba lagi.');
            }
        } catch (\Exception $e) {
            $this->addAssistantMessage('Ralat: ' . $e->getMessage());
        }
    }

    private function handleDatabaseQuery($userMessage)
    {
        try {
            // Check if this looks like a database query
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

    private function getDatabaseContext()
    {
        $schema = $this->databaseQueryService->getDatabaseSchema();
        $tableNames = array_keys($schema);

        $context = implode(', ', $tableNames);
        $context .= '. Anda boleh menanya tentang: bilangan rekod, senarai data, carian spesifik, dan statistik dari jadual-jadual ini.';

        return $context;
    }

    public function addAssistantMessage($message)
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $message,
            'timestamp' => now()->format('H:i')
        ];
        $this->isTyping = false;
        $this->isSending = false;

        // Auto-scroll to bottom after adding message
        $this->dispatch('scroll-to-bottom');
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

        // Emit event to sync with ChatGPT component if it exists on the page
        $this->dispatch('syncSystemMessageFromFloatingChat', $this->systemMessage);
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
        return view('livewire.floating-chat', [
            'availableModels' => $this->getAvailableModels()
        ]);
    }
}