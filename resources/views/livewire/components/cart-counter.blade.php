<button 
    wire:click="openCart"
    class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200"
>
    <!-- Standard shopping cart icon -->
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/>
        <circle cx="9" cy="20" r="1"/>
        <circle cx="20" cy="20" r="1"/>
    </svg>
    
    @if($item_count > 0)
        <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -right-1">
            {{ $item_count > 99 ? '99+' : $item_count }}
        </div>
    @endif
</button>