<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        let pusher = new Pusher('1ed7930cab4b02dcdb49', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
        });
    </script>
</head>
<body class="h-full font-sans antialiased">
    <!-- Toast Container -->
    <livewire:components.toast />
    
    <div class="min-h-full">
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
                                    <!-- Notification Button -->
                                    <livewire:components.notification-button />
                                    
                                    <!-- Order History Button -->
                                    <livewire:components.order-history-button />
                                    
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

            @yield('content')
            
            <!-- Cart Modal -->
            <livewire:components.cart-modal />
            
            <!-- Order History Modal -->
            <livewire:components.order-history-modal />
            
            <!-- Notification Modal -->
            <livewire:components.notification-modal />
        </div>
    </div>

    @livewireScripts
</body>
</html>