<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laravel Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-blue-600 tracking-tight">
                        Shop<span class="text-gray-900">Cart</span>
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    <livewire:cart-counter />

                    @auth
                        <div class="text-sm text-gray-700">
                            Hi, {{ auth()->user()->name ?? 'User' }}!
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

</body>
</html>