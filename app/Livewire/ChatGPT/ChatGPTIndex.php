<?php

namespace App\Livewire\ChatGPT;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ChatGPTIndex extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public $isSending = false; // Property to manage send button state
    public $errorMessage = '';
    public $embedded = false;

    protected $listeners = ['clearChatOnLogout' => 'clearChatOnLogout'];

    public function __construct()
    {
        // Constructor tanpa dependency injection yang tidak diperlukan
    }

    public function mount($embedded = false)
    {
        $this->embedded = $embedded;

        // Load messages from session if exists, otherwise initialize with welcome message
        if (session()->has('chat_messages')) {
            $this->messages = session('chat_messages');
        } else {
            $welcomeMessage = $this->embedded
                ? 'Halo! Chat siap membantu!'
                : 'Halo! Saya adalah chat assistant yang siap membantu anda. Apa yang boleh saya bantu hari ini?';

            $this->messages = [
                [
                    'role' => 'assistant',
                    'content' => $welcomeMessage,
                    'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
                ]
            ];
            // Save initial messages to session
            session(['chat_messages' => $this->messages]);
        }
    }

    protected $rules = [
        'newMessage' => 'required|string|max:2000',
    ];

    protected $messages_validation = [
        'newMessage.required' => 'Sila masukkan mesej.',
        'newMessage.string' => 'Mesej mestilah teks.',
        'newMessage.max' => 'Mesej maksimum 2000 aksara.',
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

            $this->messages[] = [
                'role' => 'user',
                'content' => $userMessage,
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ];

            // Save messages to session
            session(['chat_messages' => $this->messages]);

            // Auto-scroll to bottom after adding user message
            $this->dispatch('scroll-to-bottom');

            $this->newMessage = ''; // Clear message input
            $this->isSending = true; // Set sending state
            $this->isTyping = true; // Indicate that typing has started
            $this->errorMessage = '';

            // Call webhook directly after setting sending state
            $this->callWebhook($userMessage);
        }
    }


    private function callWebhook($message)
    {
        try {
            $url = 'https://n8n-mt8umikivytz.n8x.biz.id/webhook/46f1bc09-cc8d-457a-bb8f-00adeb499d76';
            $data = [
                'message' => $message,
                'user_id' => session('user_id'),
            ];

            if (env('APP_DEV')) {
                $response = Http::withoutVerifying()->get($url, $data);
            } else {
                $response = Http::get($url, $data);
            }

            if ($response->successful()) {
                $data = $response->json();
                $webhookResponse = $data[0]['output'] ?? 'Maaf, tidak dapat mendapatkan respons dari server.';

                $this->addAssistantMessage($webhookResponse);
            } else {
                $this->setErrorMessage('Gagal mendapatkan respons dari server. Sila cuba lagi.');
            }
        } catch (\Exception $e) {
            $this->setErrorMessage('Ralat: ' . $e->getMessage());
        } finally {
            $this->isSending = false; // Reset sending state after response
        }
    }


    public function addAssistantMessage($message)
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $message,
            'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
        ];
        $this->isTyping = false;

        // Save messages to session
        session(['chat_messages' => $this->messages]);

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
                'content' => 'Halo! Chat telah direset. Apa yang boleh saya bantu hari ini?',
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ]
        ];
        $this->errorMessage = '';

        // Clear messages from session and save welcome message
        session(['chat_messages' => $this->messages]);
    }

    public function clearChatOnLogout()
    {
        // Clear all chat-related session data on logout
        session()->forget(['chat_messages']);
        $this->messages = [];
    }

    public function checkTypingStatus()
    {
        // This method is called by wire:poll to ensure reactivity
        return $this->isTyping;
    }

    public function render()
    {
        return view('livewire.chat-gpt.chat-gpt-index');
    }
}
