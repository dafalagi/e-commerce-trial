<div 
    x-data="{ open: @entangle('is_open') }"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    @keydown.escape.window="$wire.closeModal()"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" wire:click="closeModal"></div>
    
    <!-- Modal Panel -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white px-6 py-8 shadow-xl transition-all"
            @click.stop
        >
            <!-- Header -->
            <div class="mb-6">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 mb-4">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center">Forgot Password?</h3>
                <p class="mt-2 text-sm text-gray-600 text-center">
                    No worries! Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>

            <!-- Form -->
            <form wire:submit="sendResetLink" class="space-y-4">
                <!-- Email Input -->
                <div>
                    <label for="forgot-email" class="block text-sm font-medium leading-6 text-gray-900">
                        Email address
                    </label>
                    <div class="mt-2">
                        <input 
                            wire:model="email"
                            id="forgot-email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            placeholder="Enter your email address"
                            class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                            wire:loading.attr="disabled"
                            wire:target="sendResetLink"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col space-y-3 pt-4">
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        wire:target="sendResetLink"
                        class="relative flex w-full justify-center items-center rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-75 disabled:cursor-not-allowed transition-all duration-200 min-h-[42px]"
                    >
                        <!-- Loading Spinner -->
                        <svg 
                            wire:loading 
                            wire:target="sendResetLink"
                            class="animate-spin h-4 w-4 text-white mr-2" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24"
                        >
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <!-- Button Text -->
                        <span wire:loading.remove wire:target="sendResetLink">Send Reset Link</span>
                        <span wire:loading wire:target="sendResetLink">Sending...</span>
                    </button>
                    
                    <button 
                        type="button" 
                        wire:click="closeModal"
                        class="flex w-full justify-center rounded-md bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all duration-200"
                    >
                        Cancel
                    </button>
                </div>
            </form>

            <!-- Close Button -->
            <button 
                wire:click="closeModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>