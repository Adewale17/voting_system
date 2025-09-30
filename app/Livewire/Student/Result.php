<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Election;

class Result extends Component
{
    public $elections;

    public function mount()
    {
        // Load elections with candidates and votes
        $this->elections = Election::with(['candidates.votes'])->get();
    }

    public function render()
    {
        return view('livewire.student.result')
            ->layout('layouts.student.app', ['title' => 'Election Results']);
    }
}
