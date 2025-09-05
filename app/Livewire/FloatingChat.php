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

    protected $listeners = ['openChat' => 'openChat'];
    protected $databaseQueryService;

    public function __construct()
    {
        $this->databaseQueryService = new DatabaseQueryService();
    }

    public function mount()
    {
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

        // Check for invoice search first
        $invoiceSearch = $this->detectInvoiceSearch($userMessage);
        if ($invoiceSearch) {
            $this->redirectToInvoiceSearch($invoiceSearch);
            $this->addAssistantMessage("Saya sedang mengarahkan anda ke halaman invoice untuk mencari nombor: " . $invoiceSearch);
            return;
        }

        // Call AI API
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
                    'content' => 'You are a helpful AI assistant with access to a business management database. ' .
                        'Respond in Malay language unless specifically asked otherwise. ' .
                        'You have access to the following database tables: ' . $schemaInfo . '. ' .
                        'If the user asks about data, provide helpful analysis and insights based on the available information. ' .
                        'Always be helpful, accurate, and provide actionable information.'
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


    public function render()
    {
        return view('livewire.floating-chat');
    }
}