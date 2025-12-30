@extends('layouts.app')

@section('content')
<div class="min-h-full" style="background-color: #f9fafb;">
    <nav class="bg-white border-b border-gray-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.119-1.243l1.263-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                        <span class="ml-2 text-xl font-semibold">E-Commerce</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="relative ml-3">
                        <div class="flex items-center space-x-4">
                            <!-- Order History Button -->
                            <button 
                                onclick="$dispatch('toggle-order-history')"
                                class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors"
                                title="Order History"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="text-sm">Orders</span>
                            </button>
                            
                            <!-- Cart Counter -->
                            <livewire:components.cart-counter />
                            
                            <span class="text-sm text-gray-700">Hello, {{ Auth::user()->email }}!</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-10" style="background-color: #f9fafb;">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">Products</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <livewire:product.product-listing />
            </div>
        </main>
    </div>
    
    <!-- Cart Modal -->
    <livewire:components.cart-modal />
    
    <!-- Order History Modal -->
    <livewire:components.order-history-modal />
</div>
@endsection