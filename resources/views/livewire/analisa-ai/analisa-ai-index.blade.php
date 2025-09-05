<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-brain text-blue-600 mr-3"></i>
                    Analisa AI
                </h1>
                <p class="text-gray-600">Muat naik gambar dan dapatkan analisis AI berdasarkan prompt anda</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Model AI:</label>
                    <select wire:model.live="selectedModel" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                        @foreach($availableModels as $key => $model)
                            <option value="{{ $key }}" {{ $selectedModel === $key ? 'selected' : '' }}>
                                {{ $model }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input Section -->
        <div class="space-y-6">
            <!-- Image Upload -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-upload text-blue-600 mr-2"></i>
                        Muat Naik Gambar
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">Pilih gambar untuk dianalisis oleh AI</p>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <!-- File Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">
                                Pilih Gambar
                            </label>
                            <input type="file" wire:model="image" accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('image') border-red-500 bg-red-50 @enderror">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Saiz maksimum: 5MB</p>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        @if ($image)
                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Pratonton Gambar</label>
                                <div class="relative">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="w-full max-w-md h-64 object-cover rounded-lg shadow-lg">
                                    <button wire:click="$set('image', null)"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Prompt Input -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-comment-dots text-green-600 mr-2"></i>
                        Prompt Analisis
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">Beritahu AI apa yang perlu dianalisis</p>
                </div>

                <div class="p-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Prompt
                        </label>
                        <textarea wire:model="prompt" rows="4"
                            placeholder="Contoh: Terangkan apa yang ada dalam gambar ini. Analisa warna, objek, dan suasana..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 @error('prompt') border-red-500 bg-red-50 @enderror"></textarea>
                        <p class="mt-1 text-sm text-gray-500">Berikan arahan yang jelas untuk mendapatkan analisis yang
                            lebih baik</p>
                        @error('prompt')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Use fetch API instead of OpenAI library -->
            <script>
                // Simple fetch-based AI analysis
                async function callAIAPI(prompt, base64Image) {
                    const response = await fetch('https://ai.sumopod.com/v1/chat/completions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer sk-6kaYJsk90RNguElbuHmmMQ'
                        },
                        body: JSON.stringify({
                            model: @js($selectedModel),
                            messages: [{
                                role: 'user',
                                content: [
                                    {
                                        type: "text",
                                        text: prompt
                                    },
                                    {
                                        type: "image_url",
                                        image_url: {
                                            url: base64Image
                                        }
                                    }
                                ]
                            }],
                            max_tokens: 1000,
                            temperature: 0.7
                        })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    return data.choices[0].message.content;
                }
            </script>

            <script>
                // Convert file to base64
                function fileToBase64(file) {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = () => resolve(reader.result);
                        reader.onerror = error => reject(error);
                    });
                }

                // Analyze image with AI using fetch API
                async function analyzeImageWithAI() {
                    const imageInput = document.querySelector('input[type="file"][wire\\:model="image"]');
                    const promptTextarea = document.querySelector('textarea[wire\\:model="prompt"]');
                    const analyzeBtn = document.getElementById('analyze-btn');
                    const analyzeText = document.getElementById('analyze-text');
                    const analyzingText = document.getElementById('analyzing-text');

                    // Validate inputs
                    if (!imageInput.files[0]) {
                        alert('Sila pilih gambar untuk dianalisis.');
                        return;
                    }

                    if (!promptTextarea.value.trim()) {
                        alert('Sila masukkan prompt untuk analisis.');
                        return;
                    }

                    // Show loading state
                    analyzeBtn.disabled = true;
                    analyzeText.classList.add('hidden');
                    analyzingText.classList.remove('hidden');

                    try {
                        // Convert image to base64
                        const imageFile = imageInput.files[0];
                        const base64Image = await fileToBase64(imageFile);

                        // Call AI API using fetch
                        const result = await callAIAPI(promptTextarea.value.trim(), base64Image);

                        // Update Livewire component with result
                        @this.updateAnalysisResult(result);

                    } catch (error) {
                        console.error('AI Analysis Error:', error);
                        let errorMessage = 'Gagal mendapatkan respons dari AI. Sila cuba lagi.';

                        if (error.message) {
                            errorMessage = `Ralat: ${error.message}`;
                        }

                        @this.updateErrorMessage(errorMessage);
                    } finally {
                        // Reset loading state
                        analyzeBtn.disabled = false;
                        analyzeText.classList.remove('hidden');
                        analyzingText.classList.add('hidden');
                    }
                }

                // Test function
                function testOpenAI() {
                    alert('AI API siap untuk digunakan! Muat naik gambar dan masukkan prompt untuk memulakan analisis.');
                }

                // Initialize when DOM is loaded
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Analisa AI page loaded and ready');
                });
            </script>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button onclick="analyzeImageWithAI()" id="analyze-btn"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-brain mr-2"></i>
                    <span id="analyze-text">Analisa dengan AI</span>
                    <span id="analyzing-text" class="hidden">Menganalisa...</span>
                </button>

                <button wire:click="resetForm"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    <i class="fas fa-redo mr-2"></i>
                    Reset
                </button>

                <button onclick="testOpenAI()"
                    class="inline-flex items-center justify-center px-6 py-3 border border-blue-300 text-blue-700 font-medium rounded-xl hover:bg-blue-50 transition-colors duration-300">
                    <i class="fas fa-vial mr-2"></i>
                    Test AI
                </button>
            </div>
        </div>

        <!-- Results Section -->
        <div class="space-y-6">
            <!-- Analysis Results -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                        Hasil Analisis AI
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">Output dari AI berdasarkan gambar dan prompt anda</p>
                </div>

                <div class="p-6">
                    @if ($isAnalyzing)
                        <div class="flex flex-col items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                            <p class="text-gray-600">AI sedang menganalisa gambar...</p>
                            <p class="text-sm text-gray-500 mt-2">Sila tunggu sebentar</p>
                        </div>
                    @elseif($errorMessage)
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <div>
                                    <p class="font-medium">Ralat Analisis</p>
                                    <p class="text-sm">{{ $errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($analysisResult)
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="font-medium">Analisis Berjaya!</span>
                            </div>
                        </div>

                        <div class="prose prose-sm max-w-none">
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Hasil Analisis:</h4>
                                <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                                    {!! nl2br(e($analysisResult)) !!}
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-robot mr-1"></i>
                                        Model: {{ $selectedModel }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button onclick="navigator.clipboard.writeText(`{{ addslashes($analysisResult) }}`)"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-copy mr-2"></i>
                                Salin Hasil
                            </button>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div
                                class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-brain text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Hasil Analisis</h3>
                            <p class="text-gray-500">Muat naik gambar dan masukkan prompt untuk mendapatkan analisis AI
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tips Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h4 class="text-lg font-semibold text-blue-900 mb-3">
                    <i class="fas fa-lightbulb text-blue-600 mr-2"></i>
                    Tips untuk Analisis yang Lebih Baik
                </h4>
                <ul class="text-sm text-blue-800 space-y-2">
                    <li>• <strong>Jadikan prompt spesifik:</strong> "Terangkan objek utama dalam gambar ini" vs "Apa
                        yang ada dalam gambar?"</li>
                    <li>• <strong>Tentukan bahasa:</strong> "Jawab dalam bahasa Melayu" untuk hasil dalam bahasa Melayu
                    </li>
                    <li>• <strong>Minta perincian:</strong> "Berikan analisis terperinci tentang warna, bentuk, dan
                        konteks"</li>
                    <li>• <strong>Gambar berkualiti tinggi:</strong> Gambar yang jelas memberikan analisis yang lebih
                        tepat</li>
                </ul>
            </div>
        </div>
    </div>
</div>
