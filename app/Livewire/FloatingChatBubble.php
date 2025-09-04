<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FloatingChatBubble extends Component
{
    public $showChatModal = false;
    public $showPasswordModal = false;
    public $password = '';
    public $passwordError = '';
    public $selectedModel = 'gemini/gemini-2.0-flash-lite';
    public $pendingModel = '';

    protected $listeners = [
        'openChatModal' => 'openChatModal',
        'closeChatModal' => 'closeChatModal',
        'requestModelChange' => 'requestModelChange'
    ];

    public function mount()
    {
        $this->selectedModel = 'gemini/gemini-2.0-flash-lite';
    }

    public function openChatModal()
    {
        // Simple debug - this will show if the method is called
        $this->showChatModal = true;
        $this->dispatch('chat-modal-opened');
        // Add a flash message for debugging
        session()->flash('debug', 'Chat modal opened at ' . now());
    }

    public function closeChatModal()
    {
        $this->showChatModal = false;
        $this->resetPasswordFields();
    }

    public function requestModelChange($model)
    {
        $this->pendingModel = $model;
        $this->showPasswordModal = true;
        $this->password = '';
        $this->passwordError = '';
    }

    public function verifyPassword()
    {
        $this->passwordError = '';

        if (empty($this->password)) {
            $this->passwordError = 'Sila masukkan kata laluan.';
            return;
        }

        $user = Auth::user();
        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->passwordError = 'Kata laluan tidak sah.';
            return;
        }

        // Password verified, change the model
        $this->selectedModel = $this->pendingModel;
        $this->closePasswordModal();

        // Emit event to update the chat component
        $this->dispatch('modelChanged', model: $this->selectedModel);

        session()->flash('message', 'Model berjaya ditukar kepada: ' . $this->getModelDisplayName($this->selectedModel));
    }

    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->resetPasswordFields();
    }

    private function resetPasswordFields()
    {
        $this->password = '';
        $this->passwordError = '';
        $this->pendingModel = '';
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

    private function getModelDisplayName($modelKey)
    {
        $models = $this->getAvailableModels();
        return $models[$modelKey] ?? $modelKey;
    }

    public function render()
    {
        return view('livewire.floating-chat-bubble', [
            'availableModels' => $this->getAvailableModels()
        ]);
    }
}