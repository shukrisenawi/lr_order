@extends('layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
    @livewire('pengumuman.pengumuman-form', ['pengumuman' => $pengumuman])
@endsection