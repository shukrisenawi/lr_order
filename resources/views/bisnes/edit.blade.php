@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
    <livewire:bisnes.bisnes-form :bisnes="$bisnes" />
@endsection
