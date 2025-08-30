@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <livewire:invoice.invoice-form :customer="$customer" />
@endsection
