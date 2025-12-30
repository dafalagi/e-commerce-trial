<div class="fixed top-4 right-4 z-60 space-y-2">
    @foreach($messages as $message)
    <div 
        wire:key="toast-{{ $message['id'] }}"
        x-data="{ show: false }"
        x-init="
            setTimeout(() => show = true, 50);
            setTimeout(() => {
                show = false;
                setTimeout(() => $wire.removeToast('{{ $message['id'] }}'), 300);
            }, 2000);
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative flex items-start p-4 rounded-lg shadow-lg border max-w-sm w-full transform
            @if($message['type'] === 'error') bg-red-50 border-red-200 text-red-800
            @elseif($message['type'] === 'success') bg-red-50 border-green-200 text-green-800
            @elseif($message['type'] === 'warning') bg-yellow-50 border-yellow-200 text-yellow-800
            @elseif($message['type'] === 'info') bg-blue-50 border-blue-200 text-blue-800
            @else bg-gray-50 border-gray-200 text-gray-800
            @endif
        "
    >
        <!-- Message -->
        <div class="flex-1">
            <p class="text-sm font-medium">
                {{ $message['message'] }}
            </p>
        </div>
        
        <!-- Close Button -->
        <button 
            @click="show = false; setTimeout(() => $wire.removeToast('{{ $message['id'] }}'), 300);"
            class="ml-3 text-gray-400 hover:text-gray-600 transition-colors duration-200"
        >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
    @endforeach
</div>
