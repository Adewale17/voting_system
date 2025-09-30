<div class="p-6 bg-gray-100 min-h-screen space-y-6">

    {{-- Flash Messages --}}
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-lg shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Election Management</h1>
        <span class="text-gray-600">Create, edit, or manage elections</span>
    </div>

    <!-- Add/Edit Election -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">
            {{ $editingElectionId ? 'Edit Election' : 'Add Election' }}
        </h2>

        <form wire:submit.prevent="saveElection" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" wire:model="title" placeholder="Election Title"
                       class="p-3 rounded border w-full focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <select wire:model="status"
                        class="p-3 rounded border w-full bg-white focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                    <option value="">Select Status</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                </select>
                @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <input type="datetime-local" wire:model="start_date"
                       class="p-3 rounded border w-full focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <input type="datetime-local" wire:model="end_date"
                       class="p-3 rounded border w-full focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <textarea wire:model="description" rows="3" placeholder="Election Description"
                      class="p-3 rounded border w-full focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div class="flex space-x-4 mt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded shadow">
                    {{ $editingElectionId ? 'Update Election' : 'Add Election' }}
                </button>

                @if($editingElectionId)
                    <button type="button" wire:click="$set('editingElectionId', null)"
                            class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <input type="text" wire:model.debounce.300ms="search"
               placeholder="Search by title or description"
               class="p-3 rounded border w-full md:w-1/3 focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Election Table -->
   <div class="overflow-x-auto mt-6 bg-white shadow-lg rounded-xl">
    <table class="min-w-full border-collapse">
        <thead>
            <tr class="bg-gradient-to-r from-green-50 to-green-100 text-gray-700 text-sm uppercase tracking-wide">
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-center">Status</th>
                <th class="p-3 text-center">Start Date</th>
                <th class="p-3 text-center">End Date</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
            @forelse($elections as $election)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 font-semibold text-gray-900">{{ $election->title }}</td>
                    <td class="p-3 text-gray-600">
                        {{ Str::limit($election->description, 50) }}
                    </td>
                    <td class="p-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($election->status === 'upcoming') bg-yellow-100 text-yellow-700
                            @elseif($election->status === 'ongoing') bg-green-100 text-green-700
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ ucfirst($election->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        {{ $election->start_date ? \Carbon\Carbon::parse($election->start_date)->format('M d, Y • H:i') : '—' }}
                    </td>
                    <td class="p-3 text-center">
                        {{ $election->end_date ? \Carbon\Carbon::parse($election->end_date)->format('M d, Y • H:i') : '—' }}
                    </td>
                    <td class="p-3 text-center space-x-2">
                        <button wire:click="editElection({{ $election->id }})"
                            class="inline-flex items-center px-3 py-1 bg-yellow-400 text-white rounded-lg shadow hover:bg-yellow-500 transition">
                            Edit
                        </button>
                        <button wire:click="deleteElection({{ $election->id }})"
                            class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500 italic">
                        No elections found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="p-4 border-t bg-gray-50 rounded-b-xl">
        {{ $elections->links() }}
    </div>
</div>

</div>
