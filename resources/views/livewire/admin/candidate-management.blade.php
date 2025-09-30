<div class="p-6 bg-gray-50 min-h-screen space-y-8">

    {{-- Flash Messages --}}
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Candidate Management</h1>
            <p class="text-gray-500 mt-1">Add, edit, or manage election candidates</p>
        </div>

    </div>

    <!-- Add/Edit Candidate -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-xl font-bold text-gray-700 mb-6 flex items-center space-x-2">
            <i class="fas fa-user-plus text-green-600"></i>
            <span>{{ $editingCandidateId ? 'Update Candidate' : 'Add New Candidate' }}</span>
        </h2>

        <form wire:submit.prevent="saveCandidate" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">First Name</label>
                    <input type="text" wire:model="first_name"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('first_name') border-red-500 @enderror"
                           placeholder="Enter first name">
                    @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Last Name</label>
                    <input type="text" wire:model="last_name"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('last_name') border-red-500 @enderror"
                           placeholder="Enter last name">
                    @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Other Name</label>
                    <input type="text" wire:model="other_name"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('other_name') border-red-500 @enderror"
                           placeholder="Enter middle/other name">
                    @error('other_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Matric Number</label>
                    <input type="text" wire:model="matric_no"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('matric_no') border-red-500 @enderror"
                           placeholder="e.g H/CS/22/0980">
                    @error('matric_no') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Position</label>
                    <input type="text" wire:model="position"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('position') border-red-500 @enderror"
                           placeholder="e.g President, Treasurer">
                    @error('position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Election</label>
                    <select wire:model="election_id"
                            class="w-full p-3 border rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('election_id') border-red-500 @enderror">
                        <option value="">Select Election</option>
                        @foreach($elections as $election)
                            <option value="{{ $election->id }}">{{ $election->title }}</option>
                        @endforeach
                    </select>
                    @error('election_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Photo</label>
                    <input type="file" wire:model="photo" accept="image/*"
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('photo') border-red-500 @enderror">
                    @error('photo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg shadow-md transition">
                    {{ $editingCandidateId ? 'Update Candidate' : 'Add Candidate' }}
                </button>

                @if($editingCandidateId)
                    <button type="button" wire:click="$set('editingCandidateId', null)"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Candidate Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <input type="text" wire:model.live="search"
                   placeholder="Search candidates..."
                   class="w-full md:w-1/3 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            <select wire:model.live="statusFilter"
                    class="w-full md:w-1/4 p-3 border rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Filter by Status</option>
                <option value="ongoing"> ongoing</option>
                <option value="upcoming"> upcoming</option>
                <option value="completed"> completed</option>
            </select>

                    <button wire:click="exportCandidates"
            class="mt-4 md:mt-0 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow flex items-center space-x-2">
            <i class="fas fa-file-pdf"></i>
            <span>Export PDF</span>
        </button>
        </div>

       <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Photo</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Matric No</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Position</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Election</th>
                <th class="px-6 py-3 text-center text-sm font-semibold tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($candidates as $candidate)
                <tr class="hover:bg-gray-50 transition">
                    <!-- Photo -->
                    <td class="px-6 py-4">
                        @if($candidate->photo)
                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                 alt="Photo"
                                 class="w-12 h-12 rounded-full object-cover border shadow-sm">
                        @else
                            <span class="text-gray-400 italic text-sm">No photo</span>
                        @endif
                    </td>

                    <!-- Name -->
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $candidate->first_name }} {{ $candidate->other_name }} {{ $candidate->last_name }}
                    </td>

                    <!-- Matric No -->
                    <td class="px-6 py-4">{{ $candidate->matric_no }}</td>

                    <!-- Position -->
                    <td class="px-6 py-4">{{ $candidate->position }}</td>

                    <!-- Election -->
                    <td class="px-6 py-4">{{ $candidate->election->title ?? 'N/A' }}</td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-center space-x-2">
                        <button wire:click="editCandidate({{ $candidate->id }})"
                            class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 hover:scale-105 transition">
                            Edit
                        </button>
                        <button wire:click="deleteCandidate({{ $candidate->id }})"
                            class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 hover:scale-105 transition">
                            Delete
                        </button>
                        {{-- <button wire:click="toggleStatus({{ $candidate->id }})"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 hover:scale-105 transition">
                            🔄 Toggle
                        </button> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-6 text-center text-gray-500 italic">
                        No candidates found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


        <div class="p-4">
            {{ $candidates->links() }}
        </div>
    </div>
</div>
