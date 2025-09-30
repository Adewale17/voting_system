<form wire:submit.prevent="login" class="space-y-4">
    <!-- Email -->
    <div>
        <input type="email" wire:model="email" placeholder="Email Address"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <input type="password" wire:model="password" placeholder="Password"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="flex items-center justify-between">
        <label class="flex items-center text-sm">
            <input type="checkbox" wire:model="remember" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
            Remember Me
        </label>
        <a href="#" class="text-sm text-green-600 hover:underline">Forgot Password?</a>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-green-600 text-white rounded-lg py-3 font-semibold hover:bg-green-700 transition-colors">
        Sign In
    </button>
</form>
