<div class="space-y-10">

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500">Total Positions</h3>
            <p class="text-3xl font-bold text-green-700">{{ $totalPositions }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500">Votes Cast</h3>
            <p class="text-3xl font-bold text-green-700">{{ $votesCast }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-gray-500">Elections Status</h3>
            <p class="text-2xl font-bold {{ $electionOpen ? 'text-green-600' : 'text-green-600' }}">
                {{ $electionOpen ? 'Open' : 'Active' }}
            </p>
        </div>
    </div>

    <!-- Live Results -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-2xl font-bold text-green-700 mb-6">Election Results</h3>

        @foreach ($elections as $election)
            <div class="mb-10">
                <!-- Election Title + Status -->
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h4 class="text-xl font-semibold text-gray-800">{{ $election->title }}</h4>
                    {{-- <span class="px-3 py-1 text-sm font-semibold rounded
                                {{ $election->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-green-700' }}">
                        {{ ucfirst($election->status) }}
                    </span> --}}
                </div>

                <!-- Candidates by Position -->
                @foreach ($election->candidates->groupBy('position') as $position => $candidates)
                    <div class="mb-6">
                        <h5 class="text-lg font-bold text-gray-600 mb-2">{{ ucfirst($position) }}</h5>

                        @php
                            $totalVotes = $candidates->sum(fn($c) => $c->votes->count());
                        @endphp

                        <div class="space-y-3">
                            @foreach ($candidates as $candidate)
                                @php
                                    $voteCount = $candidate->votes->count();
                                    $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 2) : 0;
                                @endphp

                                <div class="flex items-center space-x-4 bg-gray-50 p-3 rounded-lg shadow-sm">
                                    <!-- Candidate Photo -->
                                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : 'https://via.placeholder.com/50' }}"
                                         class="w-12 h-12 rounded-full object-cover border">

                                    <!-- Candidate Info -->
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">
                                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $voteCount }} votes ({{ $percentage }}%)
                                        </p>

                                        <!-- Progress Bar -->
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-green-600 h-2 rounded-full"
                                                 style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Profile Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-green-700 mb-4">My Profile</h3>
        @php $user = Auth::guard('user')->user(); @endphp
        <p><span class="font-semibold">Name:</span> {{ $user->first_name }} {{ $user->last_name }}</p>
        <p><span class="font-semibold">Matric No:</span> {{ $user->matric_no }}</p>
        {{-- <p><span class="font-semibold">Department:</span> {{ $user->department }}</p> --}}
    </div>

</div>
