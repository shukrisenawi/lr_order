@extends('layouts.app')

@section('title', 'Edit Landing Page')

@section('content')
    @livewire('landing-page.landing-page-form', ['landingPage' => $landingPage])
@endsection