<div class="bg-white px-6 py-8 shadow-sm ring-1 ring-gray-900/5 rounded-lg"
     x-data 
     x-on:redirect-after-success.window="setTimeout(() => $wire.redirectToProducts(), 2000)">
    <form wire:submit="register" class="space-y-6">
        <!-- Email Input -->
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                Email address <span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <input 
                    wire:model="email"
                    id="email" 
                    name="email" 
                    type="email" 
                    autocomplete="email" 
                    required 
                    placeholder="Enter your email address"
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                >
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Input -->
        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                Password <span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <input 
                    wire:model="password"
                    id="password" 
                    name="password" 
                    type="password" 
                    autocomplete="new-password" 
                    required 
                    placeholder="Create a strong password (min. 8 characters)"
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                >
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation Input -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">
                Confirm Password <span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <input 
                    wire:model="password_confirmation"
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    autocomplete="new-password" 
                    required 
                    placeholder="Confirm your password"
                    class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-colors duration-200"
                >
            </div>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Send Client's Timezone -->
        <input 
            type="hidden" 
            wire:model="timezone" 
            x-data 
            x-init="
                $wire.set('timezone', Intl.DateTimeFormat().resolvedOptions().timeZone);
            "
        >

        <!-- Terms Agreement -->
        <div class="flex items-start">
            <div class="flex h-6 items-center">
                <input 
                    id="agree-terms" 
                    name="agree-terms" 
                    type="checkbox" 
                    required
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                >
            </div>
            <div class="ml-3 text-sm leading-6">
                <label for="agree-terms" class="text-gray-600">
                    I agree to the 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                        Terms of Service
                    </a>
                    and 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                        Privacy Policy
                    </a>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                wire:target="register"
                class="relative flex w-full justify-center items-center rounded-md bg-indigo-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-75 disabled:cursor-not-allowed transition-all duration-200 min-h-[42px]"
            >
                <!-- Loading Spinner -->
                <svg 
                    wire:loading 
                    wire:target="register"
                    class="animate-spin h-4 w-4 text-white mr-2" 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                
                <!-- Button Text -->
                <span 
                    wire:loading.remove 
                    wire:target="register"
                    class="flex items-center justify-center"
                >
                    Create Account
                </span>
                
                <!-- Loading Text -->
                <span 
                    wire:loading 
                    wire:target="register"
                    class="flex items-center justify-center"
                >
                    Creating account...
                </span>
            </button>
        </div>
    </form>

    <!-- Additional Links -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm font-medium leading-6">
                <span class="bg-white px-6 text-gray-700">Already have an account?</span>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm leading-6 text-gray-600">
                <a href="{{ route('login') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                    Sign in to your account
                </a>
            </p>
        </div>
    </div>
</div>