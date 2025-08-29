@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
    <livewire:invoice.invoice-form :invoice="$invoice" />
@endsection
