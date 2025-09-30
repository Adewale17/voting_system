<form wire:submit.prevent="login" class="space-y-4">
    <!-- Matric Number -->
    <div>
        <input type="text" wire:model.defer="matric_no" placeholder="Matric Number"
               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        @error('matric_no')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Phone Number -->
    <div>
        <input type="text" wire:model.defer="phone_number" placeholder="Phone Number"
               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        @error('phone_number')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="w-full bg-green-600 text-white rounded-lg py-3 font-semibold hover:bg-green-700 transition-colors">
        Login
    </button>
</form>
