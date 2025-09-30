<?php

namespace App\Livewire\Admin;

use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;

class ElectionManagement extends Component
{
    use WithPagination;

    public $title, $description, $status = 'upcoming', $start_date, $end_date;
    public $editingElectionId = null;
    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:upcoming,ongoing,completed',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function saveElection()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        if ($this->editingElectionId) {
            Election::findOrFail($this->editingElectionId)->update($data);
            session()->flash('message', 'Election updated successfully!');
        } else {
            Election::create($data);
            session()->flash('message', 'Election created successfully!');
        }

        $this->reset(['title', 'description', 'status', 'start_date', 'end_date', 'editingElectionId']);
    }

    public function editElection($id)
{
    $election = Election::findOrFail($id);

    $this->editingElectionId = $id;
    $this->title = $election->title;
    $this->description = $election->description;
    $this->status = $election->status;
    $this->start_date = $election->start_date ? \Carbon\Carbon::parse($election->start_date)->format('Y-m-d\TH:i') : null;
    $this->end_date = $election->end_date ? \Carbon\Carbon::parse($election->end_date)->format('Y-m-d\TH:i') : null;
}


    public function deleteElection($id)
    {
        Election::findOrFail($id)->delete();
        session()->flash('message', 'Election deleted successfully!');
    }

    public function render()
    {
        $elections = Election::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.election-management', compact('elections'))
            ->layout('layouts.admin.app', ['header' => 'Election Management']);
    }
}
