<div class="space-y-10">
    <h1 class="text-3xl font-bold text-green-700 mb-8">Election Results</h1>

    @foreach ($elections as $election)
        <div class="bg-white p-6 rounded-lg shadow">
            <!-- Election Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">
                {{ $election->title }}
            </h2>

            <!-- Group results by position -->
            @foreach ($election->candidates->groupBy('position') as $position => $candidates)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-green-600 mb-3">{{ ucfirst($position) }}</h3>

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
