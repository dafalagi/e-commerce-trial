<div 
    x-data="{ open: @entangle('is_open') }"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-hidden"
    style="display: none;"
    @keydown.escape.window="$wire.closeModal()"
>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50" wire:click="closeModal"></div>
    
    <!-- Modal Panel -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col"
        style="width: 33.333333%;"
        @click.stop
    >
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Order History
                @if($orders && $orders->count() > 0)
                    <span class="text-sm font-normal text-gray-500">({{ $orders->count() }} {{ Str::plural('order', $orders->count()) }})</span>
                @endif
            </h2>
            <button 
                wire:click="closeModal"
                class="text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @if($orders && $orders->count() > 0)
            <!-- Orders List -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors" wire:key="order-{{ $order->uuid }}">
                            <!-- Order Header -->
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Order #{{ substr($order->uuid, 0, 8) }}</h3>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($order->total_price, 2) }}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->payment_status->label()) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    {{ $order->orderItems->sum('quantity') }} {{ Str::plural('item', $order->orderItems->sum('quantity')) }}
                                </p>
                                <button 
                                    wire:click="viewOrderDetail('{{ $order->uuid }}')"
                                    class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex items-center justify-center p-6">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                    <p class="text-gray-600 mb-4">You haven't placed any orders yet.</p>
                    <button 
                        wire:click="closeModal"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Start Shopping
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>