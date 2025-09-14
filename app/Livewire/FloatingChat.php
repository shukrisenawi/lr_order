<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class FloatingChat extends Component
{
    public $isOpen = false;
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public $isSending = false;
    public $errorMessage = '';

    protected $listeners = ['openChat' => 'openChat', 'clearChatOnLogout' => 'clearChatOnLogout'];

    protected $rules = [
        'newMessage' => 'required|string|max:2000',
    ];

    protected $messages_validation = [
        'newMessage.required' => 'Sila masukkan mesej.',
        'newMessage.string' => 'Mesej mestilah teks.',
        'newMessage.max' => 'Mesej maksimum 2000 aksara.',
    ];


    public function mount()
    {
        if (session()->has('logout')) {
            $this->clearChat();
        }

        // Load messages from session if exists, otherwise initialize with welcome message
        if (session()->has('floating_chat_messages')) {
            $this->messages = session('floating_chat_messages');
        } else {
            $welcomeMessage = 'Halo! Saya adalah chat assistant yang siap membantu anda. Apa yang boleh saya bantu hari ini?';

            $this->messages = [
                [
                    'role' => 'assistant',
                    'content' => $welcomeMessage,
                    'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
                ]
            ];
            // Save initial messages to session
            session(['floating_chat_messages' => $this->messages]);
        }
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
            session(['floating_chat_messages' => $this->messages]);

            // Auto-scroll to bottom after adding user message
            $this->dispatch('scroll-to-bottom');

            $this->newMessage = ''; // Clear message input
            $this->isSending = true; // Set sending state
            $this->isTyping = true; // Indicate that typing has started
            $this->errorMessage = '';

            // Add temporary processing message
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Sedang memproses...',
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ];
            session(['floating_chat_messages' => $this->messages]);
            $this->dispatch('scroll-to-bottom');

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
                'user_id' => "floating_" . session('user_id'),
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
        // Check if the last message is the temporary processing message
        $lastMessage = end($this->messages);
        if ($lastMessage && $lastMessage['role'] === 'assistant' && $lastMessage['content'] === 'Sedang memproses...') {
            // Replace the temporary message with the actual response
            $this->messages[key($this->messages)] = [
                'role' => 'assistant',
                'content' => $message,
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ];
        } else {
            // Add new message if no temporary message exists
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $message,
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ];
        }
        $this->isTyping = false;

        // Save messages to session
        session(['floating_chat_messages' => $this->messages]);

        // Auto-scroll to bottom after adding message
        $this->dispatch('scroll-to-bottom');
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
        $this->isTyping = false;

        // Replace the temporary processing message with error message
        $lastMessage = end($this->messages);
        if ($lastMessage && $lastMessage['role'] === 'assistant' && $lastMessage['content'] === 'Sedang memproses...') {
            $this->messages[key($this->messages)] = [
                'role' => 'assistant',
                'content' => $message,
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ];
            session(['floating_chat_messages' => $this->messages]);
            $this->dispatch('scroll-to-bottom');
        }
    }


    public function clearChat()
    {
        $this->messages = [
            [
                'role' => 'assistant',
                'content' => 'Halo! Saya adalah asisten AI yang siap membantu anda. Apa yang boleh saya bantu hari ini?',
                'timestamp' => now()->setTimezone('Asia/Kuala_Lumpur')->format('d/m/Y h:i A')
            ]
        ];
        $this->errorMessage = '';

        // Clear messages from session
        session(['floating_chat_messages' => $this->messages]);
    }

    public function clearChatOnLogout()
    {
        // Clear all chat-related session data on logout
        session()->forget(['floating_chat_messages', 'floating_chat_selected_model']);
        $this->messages = [];
    }



    public function render()
    {
        return view('livewire.floating-chat');
    }
}
