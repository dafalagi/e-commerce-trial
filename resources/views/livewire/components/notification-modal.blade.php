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
            <div class="flex items-center space-x-2">
                <h2 class="text-lg font-semibold text-gray-900">Notifications</h2>
                @if($unread_count > 0)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ $unread_count }} new
                    </span>
                @endif
            </div>
            <div class="flex items-center space-x-2">
                @if($unread_count > 0)
                    <button 
                        wire:click="markAllAsRead"
                        class="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
                    >
                        Mark all read
                    </button>
                @endif
                <button 
                    wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        @if($unread_count > 0)
            <!-- Notifications List -->
            <div class="flex-1 overflow-y-auto">
                @foreach($grouped_notifications as $date_group => $notifications)
                    <div class="p-4 border-b border-gray-100">
                        <!-- Date Header -->
                        <h3 class="text-sm font-medium text-gray-700 mb-3">{{ $date_group }}</h3>
                        
                        <!-- Notifications for this date -->
                        <div class="space-y-3">
                            @foreach($notifications as $notification)
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100 relative group" wire:key="notification-{{ $notification->uuid }}">
                                    <!-- Close/Read button -->
                                    <button 
                                        wire:click="markAsRead('{{ $notification->uuid }}')"
                                        class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity"
                                        title="Mark as read"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <!-- Notification Icon -->
                                    <div class="flex items-start space-x-3">
                                        @if($notification->type->value === 'warning')
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Notification Content -->
                                        <div class="flex-1 min-w-0 pr-6">
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $notification->title }}</h4>
                                            <p class="text-sm text-gray-600 mb-2">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ date('g:i A', $notification->created_at) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex items-center justify-center p-6">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">All caught up!</h3>
                    <p class="text-gray-600">You have no new notifications.</p>
                </div>
            </div>
        @endif
    </div>
</div>