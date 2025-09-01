@extends('layouts.app')

@section('title', 'Edit Jadual Pengajian Masjid')

@section('content')
    @livewire('jadual-pengajian.jadual-pengajian-form', ['jadual' => $jadual])
@endsection