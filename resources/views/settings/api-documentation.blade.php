@extends('layouts.app')

@section('title', 'Dokumentasi API')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Dokumentasi API</h1>
            <p class="text-gray-500">Panduan lengkap untuk menggunakan Business Management API</p>
        </div>

        <!-- API Overview -->
        <div class="bg-white border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Gambaran Keseluruhan</h2>
            <p class="text-gray-600 mb-4">
                Business Management API membolehkan anda mengakses maklumat prospek, alamat, dan pembelian dari sistem ini.
                API ini menggunakan autentikasi token dan mengembalikan data dalam format JSON.
            </p>

            <div class="bg-blue-50 border border-blue-200 p-4 rounded">
                <h3 class="font-medium text-blue-900 mb-2">Base URL</h3>
                <code class="text-blue-800">{{ url('/api') }}</code>
            </div>
        </div>

        <!-- Authentication -->
        <div class="bg-white border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Autentikasi</h2>
            <p class="text-gray-600 mb-4">
                Semua permintaan API memerlukan token API yang sah. Sertakan token dalam header permintaan:
            </p>

            <div class="bg-gray-50 border border-gray-200 p-4 rounded">
                <pre class="text-sm"><code>X-API-Key: your_api_token_here</code></pre>
            </div>

            <div class="mt-4">
                <a href="{{ route('settings.api-tokens') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    <i class="fas fa-key mr-2"></i>
                    Urus Token API
                </a>
            </div>
        </div>

        <!-- Endpoints -->
        <div class="space-y-6">

            <!-- Get Prospects List -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-3">GET</span>
                    <h3 class="text-lg font-medium text-gray-900">/api/prospects</h3>
                </div>
                <p class="text-gray-600 mb-4">Dapatkan senarai semua prospek dalam sistem.</p>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Permintaan:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded mb-4">
                    <pre class="text-sm"><code>curl -X GET "{{ url('/api/prospects') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                </div>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Respons:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded">
                    <pre class="text-sm"><code>{
  "success": true,
  "message": "Prospects retrieved successfully",
  "data": {
    "data": [
      {
        "id": 1,
        "gelaran": "Ahmad Ali",
        "no_tel": "019-1234567",
        "email": "ahmad@example.com",
        "created_at": "2025-01-01T00:00:00.000000Z",
        "bisnes": {
          "id": 1,
          "nama_bines": "Kedai ABC",
          "nama_syarikat": "ABC Sdn Bhd"
        }
      }
    ],
    "current_page": 1,
    "total": 1
  }
}</code></pre>
                </div>
            </div>

            <!-- Get Prospect Details -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-3">GET</span>
                    <h3 class="text-lg font-medium text-gray-900">/api/prospects/{no_tel}</h3>
                </div>
                <p class="text-gray-600 mb-4">Dapatkan maklumat lengkap prospek berdasarkan no telefon termasuk bisnes,
                    alamat, dan
                    pembelian.</p>

                <h4 class="font-medium text-gray-900 mb-2">Parameter:</h4>
                <ul class="list-disc list-inside text-gray-600 mb-4">
                    <li><code>no_tel</code> - No telefon prospek yang ingin dilihat (cth: 019-1234567)</li>
                </ul>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Permintaan:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded mb-4">
                    <pre class="text-sm"><code>curl -X GET "{{ url('/api/prospects/019-1234567') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                </div>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Respons:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded">
                    <pre class="text-sm"><code>{
  "success": true,
  "message": "User details retrieved successfully",
  "data": {
    "user_info": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "total_businesses": 1,
      "total_prospects": 5,
      "total_purchases": 3
    },
    "businesses": [
      {
        "id": 1,
        "nama_bisnes": "Kedai ABC",
        "nama_syarikat": "ABC Sdn Bhd",
        "jenis_bisnes": "Runcit",
        "alamat": "123 Jalan ABC",
        "poskod": "12345",
        "no_tel": "012-3456789"
      }
    ],
    "prospects": [
      {
        "id": 1,
        "gelaran": "Ahmad Ali",
        "no_tel": "019-1234567",
        "email": "ahmad@example.com",
        "business": "Kedai ABC",
        "addresses": [
          {
            "alamat": "456 Jalan DEF",
            "bandar": "Kuala Lumpur",
            "poskod": "50000",
            "negeri": "Kuala Lumpur"
          }
        ]
      }
    ],
    "purchases": [
      {
        "id": 1,
        "prospect_name": "Ahmad Ali",
        "prospect_phone": "019-1234567",
        "business": "Kedai ABC",
        "purchase_date": "2025-01-15T10:30:00.000000Z"
      }
    ]
  }
}</code></pre>
                </div>
            </div>

            <!-- Get User Addresses -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-3">GET</span>
                    <h3 class="text-lg font-medium text-gray-900">/api/users/{id}/addresses</h3>
                </div>
                <p class="text-gray-600 mb-4">Dapatkan semua alamat yang berkaitan dengan pengguna (alamat prospek).</p>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Permintaan:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded">
                    <pre class="text-sm"><code>curl -X GET "{{ url('/api/users/1/addresses') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                </div>
            </div>

            <!-- Get Prospect Purchases -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-3">GET</span>
                    <h3 class="text-lg font-medium text-gray-900">/api/prospects/{no_tel}/purchases</h3>
                </div>
                <p class="text-gray-600 mb-4">Dapatkan semua pembelian yang berkaitan dengan prospek.</p>

                <h4 class="font-medium text-gray-900 mb-2">Contoh Permintaan:</h4>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded">
                    <pre class="text-sm"><code>curl -X GET "{{ url('/api/prospects/019-1234567/purchases') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                </div>
            </div>

            <!-- Image Management -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded mr-3">IMAGES</span>
                    <h3 class="text-lg font-medium text-gray-900">Image API Endpoints</h3>
                </div>
                <p class="text-gray-600 mb-4">Semua gambar dalam sistem dilindungi dan memerlukan API token untuk akses.</p>

                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">GET /api/images</h4>
                        <p class="text-sm text-gray-600 mb-2">Senarai semua gambar dengan URL yang selamat</p>
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded">
                            <pre class="text-sm"><code>curl -X GET "{{ url('/api/images') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">GET /api/images/serve/{path}</h4>
                        <p class="text-sm text-gray-600 mb-2">Akses gambar dengan path yang di-encode</p>
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded">
                            <pre class="text-sm"><code>curl -X GET "{{ url('/api/images/serve/base64_encoded_path') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">GET /api/images/business/{filename}</h4>
                        <p class="text-sm text-gray-600 mb-2">Akses gambar bisnes secara langsung</p>
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded">
                            <pre class="text-sm"><code>curl -X GET "{{ url('/api/images/business/logo.jpg') }}" \
  -H "X-API-Key: your_api_token_here"</code></pre>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">POST /api/images/upload</h4>
                        <p class="text-sm text-gray-600 mb-2">Muat naik gambar baru</p>
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded">
                            <pre class="text-sm"><code>curl -X POST "{{ url('/api/images/upload') }}" \
  -H "X-API-Key: your_api_token_here" \
  -F "image=@/path/to/image.jpg" \
  -F "nama=My Image"</code></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Error Responses -->
        <div class="bg-white border border-gray-200 p-6 mt-6">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Respons Ralat</h2>
            <p class="text-gray-600 mb-4">API akan mengembalikan kod status HTTP yang sesuai dan mesej ralat dalam format
                JSON:</p>

            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-900">401 Unauthorized</h4>
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded mt-2">
                        <pre class="text-sm"><code>{
  "success": false,
  "message": "API Key is required",
  "error": "Missing X-API-Key header"
}</code></pre>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900">404 Not Found</h4>
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded mt-2">
                        <pre class="text-sm"><code>{
  "success": false,
  "message": "User not found"
}</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Settings -->
        <div class="mt-8">
            <a href="{{ route('settings.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Tetapan
            </a>
        </div>
    </div>
@endsection
