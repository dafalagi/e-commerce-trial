<!-- Cart Modal Overlay -->
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
                Shopping Cart 
                @if($item_count > 0)
                    <span class="text-sm font-normal text-gray-500">({{ $item_count }} {{ Str::plural('item', $item_count) }})</span>
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

        @if($cart && $cart_items->count() > 0)
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-6">
                    @foreach($cart_items as $item)
                        <div class="flex items-start space-x-4" wire:key="cart-item-{{ $item->uuid }}">
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">${{ number_format($item->price, 2) }} each</p>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center mt-3">
                                    <button 
                                        wire:click="updateQuantity('{{ $item->uuid }}', {{ $item->quantity - 1 }})"
                                        class="flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50"
                                        @if($item->quantity <= 1) disabled @endif
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <span class="mx-3 min-w-[2rem] text-center text-sm font-medium">{{ $item->quantity }}</span>
                                    
                                    <button 
                                        wire:click="updateQuantity('{{ $item->uuid }}', {{ $item->quantity + 1 }})"
                                        class="flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50"
                                        @if ($item->quantity >= $item->product->stock) disabled @endif
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Price and Remove -->
                            <div class="flex flex-col items-end">
                                <p class="text-sm font-medium text-gray-900">${{ number_format($item->total_price, 2) }}</p>
                                <button 
                                    wire:click="removeItem('{{ $item->uuid }}')"
                                    class="mt-2 text-xs text-red-600 hover:text-red-800"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 p-6">
                <!-- Total -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-base font-medium text-gray-900">Total</span>
                    <span class="text-lg font-semibold text-gray-900">${{ number_format($total_amount, 2) }}</span>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
                        Checkout
                    </button>
                    
                    <button 
                        wire:click="clearCart"
                        class="w-full bg-white text-gray-700 py-2 px-4 rounded-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200"
                    >
                        Clear Cart
                    </button>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="flex-1 flex items-center justify-center p-6">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/>
                        <circle cx="9" cy="20" r="1"/>
                        <circle cx="20" cy="20" r="1"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 mb-4">Add some products to get started!</p>
                    <button 
                        wire:click="closeModal"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Continue Shopping
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>