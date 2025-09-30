<div class="p-6 bg-gray-100 min-h-screen space-y-6">

    {{-- Flash Messages --}}
    @if(session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Students Management</h1>
        <span class="text-gray-600">Manage all registered students</span>
    </div>

    <!-- Students Actions -->
    <div class="flex flex-col lg:flex-row gap-6 mb-6">

        <!-- Add Individual Student -->
        <div class="bg-white p-6 rounded-lg shadow flex-1">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Add Individual Student</h2>
            <form wire:submit.prevent="addStudent" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <input type="text" wire:model="first_name" placeholder="First Name"
                               class="p-3 rounded border w-full @error('first_name') border-red-500 @enderror">
                        @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="last_name" placeholder="Last Name"
                               class="p-3 rounded border w-full @error('last_name') border-red-500 @enderror">
                        @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="other_name" placeholder="Other Name"
                               class="p-3 rounded border w-full @error('other_name') border-red-500 @enderror">
                        @error('other_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="matric_no" placeholder="Matric Number"
                               class="p-3 rounded border w-full @error('matric_no') border-red-500 @enderror">
                        @error('matric_no') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="phone_number" placeholder="Phone Number"
                               class="p-3 rounded border w-full @error('phone_number') border-red-500 @enderror">
                        @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded mt-2">
                    Add Student
                </button>
            </form>
        </div>

        <!-- Bulk Upload -->
        <div class="bg-white p-6 rounded-lg shadow flex-1">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Bulk Upload (CSV)</h2>
            <form wire:submit.prevent="uploadCsv" class="space-y-4">
                <input type="file" wire:model="csvFile" accept=".csv"
                       class="p-3 rounded border w-full @error('csvFile') border-red-500 @enderror">
                @error('csvFile') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded">
                    Upload Students
                </button>
            </form>
            <p class="text-gray-500 text-sm mt-2">
                CSV format: First Name, Last Name, Other Name, Matric No, Phone Number
            </p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-6 rounded-lg shadow mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <input type="text" wire:model.live="search"
               placeholder="Search by name or matric number"
               class="p-3 rounded border w-full md:w-1/3">
        <select wire:model.live="statusFilter" class="p-3 rounded border w-full md:w-1/4">
            <option value="">Filter by Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <button wire:click="exportStudents"
    class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">
    Export Students PDF
</button>
    </div>

    <!-- Students Table -->
   <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Matric No</th>
                <th class="px-6 py-3 text-left text-sm font-semibold tracking-wide">Phone Number</th>
                <th class="px-6 py-3 text-center text-sm font-semibold tracking-wide">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
            @forelse($students as $student)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $student->first_name }} {{ $student->last_name }} {{ $student->other_name }}
                    </td>
                    <td class="px-6 py-4">{{ $student->matric_no }}</td>
                    <td class="px-6 py-4">{{ $student->phone_number }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $student->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button
                            wire:click="deleteStudent({{ $student->id }})"
                            onclick="return confirm('Are you sure you want to delete this student?')"
                            class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 hover:scale-105 transition">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                        No students found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $students->links() }}
    </div>
</div>

</div>
