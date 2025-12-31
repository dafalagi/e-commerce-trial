@extends('layouts.auth')

@section('content')    
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 mx-auto mb-6">
            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
        </div>
        <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Reset your password
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Enter your new password below to complete the reset process.
        </p>
    </div>
    
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <livewire:auth.reset-password />
    </div>
</div>
@endsection