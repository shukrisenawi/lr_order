@extends('layouts.app')

@section('title', 'Edit Program')

@section('content')
    @livewire('program.program-form', ['program' => $program])
@endsection