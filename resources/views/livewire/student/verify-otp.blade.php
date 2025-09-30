<form wire:submit.prevent="verify" class="space-y-6">
    <!-- OTP Input -->
    <div>
        <label class="block mb-2 font-medium text-gray-700">Enter OTP</label>
        <input type="text" wire:model.defer="otp" maxlength="6" placeholder="6-digit OTP"
               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none text-center text-lg tracking-widest">
        @error('otp')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="w-full bg-green-600 text-white rounded-lg py-3 font-semibold hover:bg-green-700 transition-colors">
        Verify OTP
    </button>
</form>
