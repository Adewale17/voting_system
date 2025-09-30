<div class="p-6 space-y-10">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Election Results</h1>

    @foreach ($elections as $election)
        <div class="bg-white shadow rounded-2xl p-6">
            <!-- Election Title -->
            <h2 class="text-2xl font-semibold text-blue-700 mb-8 border-b pb-2">
                {{ $election->title }}
            </h2>

            <!-- Group by Position -->
            @foreach ($election->candidates->groupBy('position') as $position => $candidates)
                @php
                    $totalVotes = $candidates->sum(fn($c) => $c->votes->count());
                @endphp

                <div class="mb-10">
                    <!-- Position Title -->
                    <h3 class="text-xl font-bold text-green-700 mb-4">
                        {{ ucfirst($position) }}
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach ($candidates as $candidate)
                            @php
                                $voteCount = $candidate->votes->count();
                                $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 2) : 0;
                            @endphp

                            <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-xl shadow-sm">
                                <!-- Candidate Picture -->
                                <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : 'https://via.placeholder.com/80' }}"
                                     alt="Candidate Photo"
                                     class="w-20 h-20 rounded-full object-cover border">

                                <!-- Candidate Info -->
                                <div class="flex-1">
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $candidate->first_name }} {{ $candidate->last_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $voteCount }} votes ({{ $percentage }}%)
                                    </p>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                                        <div class="bg-green-500 h-3 rounded-full"
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
