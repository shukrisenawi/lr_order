@extends('layouts.app')

@section('title', 'ChatGPT')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:chat-gpt.chat-gpt-index />
        </div>
    </div>
@endsection