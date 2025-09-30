<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Election;

class Results extends Component
{
    public $elections;

    public function mount()
    {
        // Fetch all elections with candidates & their votes
        $this->elections = Election::with(['candidates.votes'])->get();
    }

    public function render()
    {
        return view('livewire.admin.results')
            ->layout('layouts.admin.app');
    }
}
