<div class="dashboard-container flex flex-col space-y-8">

    <!-- Dashboard Header -->
    <div class="flex items-center justify-between">
        {{-- <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1> --}}
        <span class="text-gray-600 text-lg">Welcome, {{ auth()->user()->name ?? 'Admin' }}</span>
    </div>

    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition border-l-4 border-green-600">
            <p class="text-sm text-gray-500">Total Elections</p>
            <p class="text-2xl font-bold text-green-700">{{ $totalElections }}</p>
            <p class="text-xs text-gray-400 mt-1">+{{ $electionsThisMonth }} this month</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Active Voters</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $activeVoters }}</p>
            <p class="text-xs text-gray-400 mt-1">+{{ $votersChange }} from last election</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition border-l-4 border-green-400">
            <p class="text-sm text-gray-500">Participation Rate</p>
            <p class="text-2xl font-bold text-green-500">{{ $participationRate }}%</p>
            <p class="text-xs text-gray-400 mt-1">+{{ $participationChange }}% improvement</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition border-l-4 border-blue-400">
            <p class="text-sm text-gray-500">Upcoming Elections</p>
            <p class="text-2xl font-bold text-blue-500">{{ $upcomingElections }}</p>
            <p class="text-xs text-gray-400 mt-1">Next: {{ $nextElectionDate }}</p>
        </div>
    </div>

    <!-- Voting & Candidate Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Voting Participation -->
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Voting Participation</h2>

            @foreach([
                ['label' => 'Registered Voters', 'percent' => $registeredVotersPercent, 'color' => 'green'],
                ['label' => 'Voter Turnout', 'percent' => $turnoutPercent, 'color' => 'blue'],
                ['label' => 'Participation Improvement', 'percent' => $participationImprovement, 'color' => 'yellow']
            ] as $item)
                <div>
                    <p class="text-sm text-gray-500">{{ $item['label'] }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
                        <div class="bg-{{ $item['color'] }}-600 h-4 rounded-full" style="width: {{ $item['percent'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $item['percent'] }}%</p>
                </div>
            @endforeach
        </div>

        <!-- Candidate Overview -->
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Candidate Overview</h2>

            @foreach([
                ['label' => 'Active Candidates', 'percent' => $activeCandidatesPercent, 'color' => 'purple'],
                ['label' => 'Candidate Approval', 'percent' => $candidateApprovalPercent, 'color' => 'pink'],
                ['label' => 'Election Completed for Candidates', 'percent' => $candidateCompletionPercent, 'color' => 'indigo']
            ] as $item)
                <div>
                    <p class="text-sm text-gray-500">{{ $item['label'] }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
                        <div class="bg-{{ $item['color'] }}-600 h-4 rounded-full" style="width: {{ $item['percent'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $item['percent'] }}%</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Elections Overview -->
    <div class="bg-white p-5 rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Elections Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-50 p-4 rounded shadow">
                <p class="text-gray-600">Ongoing</p>
                <p class="text-xl font-bold text-green-700">{{ $ongoingElections }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded shadow">
                <p class="text-gray-600">Upcoming</p>
                <p class="text-xl font-bold text-yellow-600">{{ $upcomingElections }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded shadow">
                <p class="text-gray-600">Completed</p>
                <p class="text-xl font-bold text-gray-600">{{ $completedElections }}</p>
            </div>
        </div>
    </div>
</div>
