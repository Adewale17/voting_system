<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteBoard extends Component
{
    public $selectedCandidates = [];

    public function mount()
    {
        $this->selectedCandidates = [];
    }

    public function vote($electionId)
    {
        $student = Auth::guard('user')->user();

        $election = Election::with('candidates')->findOrFail($electionId);

        // Loop through each position in this election
        foreach ($election->candidates->groupBy('position') as $position => $candidates) {
            if (!isset($this->selectedCandidates[$electionId][$position])) {
                continue; // skip if no candidate selected for this position
            }

            $candidateId = $this->selectedCandidates[$electionId][$position];

            // Prevent double voting for the same position
            $alreadyVoted = Vote::where('student_id', $student->id)
                ->where('election_id', $electionId)
                ->where('position', $position)
                ->exists();

            if ($alreadyVoted) {
                session()->flash('error', "You have already voted for $position in this election.");
                continue;
            }

            // Save vote
            Vote::create([
                'student_id' => $student->id,
                'candidate_id' => $candidateId,
                'election_id' => $electionId,
                'position' => $position,
            ]);
        }

        session()->flash('success', 'Your votes have been submitted successfully!');
        $this->selectedCandidates[$electionId] = []; // reset after voting
    }

    public function render()
    {
        $elections = Election::with('candidates')->get();

        return view('livewire.student.vote-board', compact('elections'))
            ->layout('layouts.student.app', ['title' => 'Student Dashboard']);
    }
}
