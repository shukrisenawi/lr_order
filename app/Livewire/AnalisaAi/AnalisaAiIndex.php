<?php

namespace App\Livewire\AnalisaAi;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AnalisaAiIndex extends Component
{
    use WithFileUploads;

    public $image;
    public $prompt = '';
    public $analysisResult = '';
    public $isAnalyzing = false;
    public $errorMessage = '';

    public function mount()
    {
        if (session('selected_bisnes_id') != 4) {
            return redirect()->route('dashboard');
        }
    }

    protected $rules = [
        'image' => 'required|image|max:5120', // 5MB max
        'prompt' => 'required|string|max:1000',
    ];

    protected $messages = [
        'image.required' => 'Sila pilih gambar untuk dianalisis.',
        'image.image' => 'Fail yang dipilih mestilah gambar.',
        'image.max' => 'Saiz gambar maksimum 5MB.',
        'prompt.required' => 'Sila masukkan prompt untuk analisis.',
        'prompt.string' => 'Prompt mestilah teks.',
        'prompt.max' => 'Prompt maksimum 1000 aksara.',
    ];

    public function analyzeImage()
    {
        $this->validate();
        $this->isAnalyzing = true;
        $this->errorMessage = '';
        $this->analysisResult = '';

        // This will be handled by JavaScript
        // The JavaScript code will call the AI API and update the results
    }

    public function updateAnalysisResult($result)
    {
        $this->analysisResult = $result;
        $this->isAnalyzing = false;
    }

    public function updateErrorMessage($message)
    {
        $this->errorMessage = $message;
        $this->isAnalyzing = false;
    }

    public function resetForm()
    {
        $this->image = null;
        $this->prompt = '';
        $this->analysisResult = '';
        $this->errorMessage = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.analisa-ai.analisa-ai-index');
    }
}