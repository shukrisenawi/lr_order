@extends('layouts.app')

@section('title', 'Edit Waktu Solat Masjid')

@section('content')
    @livewire('waktu-solat.waktu-solat-form', ['waktu' => $waktu])
@endsection