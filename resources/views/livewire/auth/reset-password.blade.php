<div class="bg-white px-6 py-8 shadow-sm ring-1 ring-gray-900/5 rounded-lg">
    <form wire:submit="resetPassword" class="space-y-6">
        <!-- Email Input (readonly) -->
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                Email address
            </label>
            <div class="mt-2">
                <input 
                    wire:model="email"
                    id="email" 
                    name="email" 
                    type="email" 
                    autocomplete="email" 
                    required 
                    readonly
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 bg-gray-50 cursor-not-allowed sm:text-sm sm:leading-6"
                >
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password Input -->
        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                New Password
            </label>
            <div class="mt-2">
                <input 
                    wire:model="password"
                    id="password" 
                    name="password" 
                    type="password" 
                    autocomplete="new-password" 
                    required 
                    placeholder="Enter your new password"
                    minlength="8"
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                    :disabled="$wire.is_loading"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">
                Password must be at least 8 characters long.
            </p>
        </div>

        <!-- Confirm Password Input -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">
                Confirm New Password
            </label>
            <div class="mt-2">
                <input 
                    wire:model="password_confirmation"
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    autocomplete="new-password" 
                    required 
                    placeholder="Confirm your new password"
                    minlength="8"
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                    :disabled="$wire.is_loading"
                >
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="relative flex w-full justify-center items-center rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-75 disabled:cursor-not-allowed transition-all duration-200 min-h-[42px]"
            >
                <!-- Loading Spinner -->
                <svg 
                    wire:loading 
                    class="animate-spin h-4 w-4 text-white mr-2" 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                
                <!-- Button Text -->
                <span wire:loading.remove>Reset Password</span>
                <span wire:loading>Resetting...</span>
            </button>
        </div>
    </form>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <p class="text-sm leading-6 text-gray-600">
            Remember your password?
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                Back to sign in
            </a>
        </p>
    </div>
</div>