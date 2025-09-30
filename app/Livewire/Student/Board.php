<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Election;
use Illuminate\Support\Facades\Auth;

class Board extends Component
{
    public $totalPositions;
    public $votesCast;
    public $electionOpen;
    public $elections;

    public function mount()
    {
        $student = Auth::guard('user')->user();

        // Count total unique positions across all elections
        $this->totalPositions = Election::with('candidates')
            ->get()
            ->pluck('candidates')
            ->flatten()
            ->pluck('position')
            ->unique()
            ->count();

        // Votes already cast by this student
        $this->votesCast = $student->votes()->count();

        // Check if any election is currently open
        $this->electionOpen = Election::where('status', 'open')->exists();

        // Load elections with candidates and votes for real-time results
        $this->elections = Election::with(['candidates.votes'])->get();
    }

    public function render()
    {
        return view('livewire.student.board', [
            'elections' => $this->elections,
        ])->layout('layouts.student.app', [
                    'title' => 'Student Dashboard',
                ]);
    }
}
