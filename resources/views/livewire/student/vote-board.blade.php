<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-green-700">
        Welcome, {{ Auth::guard('user')->user()->first_name }}
    </h1>

    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @foreach($elections as $election)
        @php
            $hasVoted = \App\Models\Vote::where('student_id', Auth::guard('user')->id())
                        ->where('election_id', $election->id)
                        ->exists();
        @endphp

        <div class="mb-10 p-6 bg-white rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-6">{{ $election->title }}</h2>

            <form wire:submit.prevent="vote({{ $election->id }})">
                @foreach($election->candidates->groupBy('position') as $position => $candidates)
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-3">{{ ucfirst($position) }}</h3>
                        <div class="space-y-3">
                            @foreach($candidates as $candidate)
                                <label class="flex items-center space-x-3 bg-gray-50 p-2 rounded-lg hover:bg-gray-100 cursor-pointer">
                                    <input type="radio"
                                           wire:model="selectedCandidates.{{ $election->id }}.{{ $position }}"
                                           value="{{ $candidate->id }}"
                                           class="form-radio text-green-600"
                                           @disabled($hasVoted)>
                                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : 'https://via.placeholder.com/50' }}"
                                         class="w-12 h-12 rounded-full object-cover">
                                    <span>{{ $candidate->first_name }} {{ $candidate->last_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit"
                        class="mt-4 bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                        @disabled($hasVoted)>
                    {{ $hasVoted ? 'Already Voted' : 'Submit Votes' }}
                </button>
            </form>
        </div>
    @endforeach
</div>
