<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Election;
use App\Models\Student as User;
use App\Models\Candidate;
use App\Models\Vote;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $totalElections;
    public $electionsThisMonth;
    public $activeVoters;
    public $votersChange;
    public $participationRate;
    public $participationChange;
    public $upcomingElections;
    public $nextElectionDate;

    public $registeredVotersPercent;
    public $turnoutPercent;
    public $participationImprovement;

    public $activeCandidatesPercent;
    public $candidateApprovalPercent;
    public $candidateCompletionPercent;

    public $ongoingElections;
    public $completedElections;

    public function mount()
    {
        // Elections
        $this->totalElections = Election::count();
        $this->electionsThisMonth = Election::whereMonth('created_at', now()->month)->count();

        // Voters
        $this->activeVoters = Vote::distinct('student_id')->count('student_id');
        $lastElection = Election::orderBy('created_at', 'desc')->skip(1)->first();
        $previousVotes = $lastElection ? Vote::where('election_id', $lastElection->id)->count() : 0;
        $this->votersChange = $previousVotes > 0 ? $this->activeVoters - $previousVotes : $this->activeVoters;

        // Participation rate (based on registered users)
        $totalUsers = User::count();
        $this->participationRate = $totalUsers > 0 ? round(($this->activeVoters / $totalUsers) * 100, 2) : 0;
        $this->participationChange = rand(1, 5); // Replace with real calc if needed

        // Upcoming Elections
        $this->upcomingElections = Election::where('status', 'upcoming')->count();
        $this->nextElectionDate = Election::where('status', 'upcoming')->min('start_date') ?? '-';

        // Voting progress
        $this->registeredVotersPercent = $totalUsers > 0 ? round(($this->activeVoters / $totalUsers) * 100, 2) : 0;
        $this->turnoutPercent = $this->participationRate;
        $this->participationImprovement = rand(10, 40); // Example improvement metric

        // Candidate statistics
        $totalCandidates = Candidate::count();
        $activeCandidates = Candidate::whereHas('election', fn($q) => $q->where('status', 'open'))->count();
        $this->activeCandidatesPercent = $totalCandidates > 0 ? round(($activeCandidates / $totalCandidates) * 100, 2) : 0;

        $this->candidateApprovalPercent = rand(50, 90); // Placeholder metric (needs survey data)
        $this->candidateCompletionPercent = $totalCandidates > 0
            ? round((Candidate::whereHas('election', fn($q) => $q->where('status', 'completed'))->count() / $totalCandidates) * 100, 2)
            : 0;

        // Election overview
        $this->ongoingElections = Election::where('status', 'open')->count();
        $this->completedElections = Election::where('status', 'completed')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin.app', ['title' => 'Admin Dashboard']);
    }
}
