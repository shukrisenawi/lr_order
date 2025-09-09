@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <livewire:scan-cula-crud />
            </div>
        </div>
    </div>
@endsection
