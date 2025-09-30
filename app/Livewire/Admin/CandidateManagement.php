<?php

namespace App\Livewire\Admin;

use App\Models\Candidate;
use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CandidatesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidateManagement extends Component
{
    use WithPagination, WithFileUploads;


    public $search = '';
    public $statusFilter = '';
    public $first_name, $last_name, $other_name, $matric_no, $position, $photo, $election_id;
    public $editingCandidateId = null;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'other_name' => 'nullable|string|max:255',
        'matric_no' => 'nullable|string|max:50',
        'position' => 'required|string|max:255',
        'photo' => 'nullable|image|max:1024',
        'election_id' => 'nullable|exists:elections,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function saveCandidate()
    {
        $this->validate();

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_name' => $this->other_name,
            'matric_no' => $this->matric_no,
            'position' => $this->position,
            'election_id' => $this->election_id,
            'status' => 'active',
        ];

        // Handle photo upload only if a new one is provided
        if ($this->photo) {
            $data['photo'] = $this->photo->store('candidates', 'public');
        }

        if ($this->editingCandidateId) {
            $candidate = Candidate::find($this->editingCandidateId);

            // Keep the old photo if no new one is uploaded
            if (!$this->photo) {
                $data['photo'] = $candidate->photo;
            }

            $candidate->update($data);
            session()->flash('message', 'Candidate updated successfully!');
        } else {
            Candidate::create($data);
            session()->flash('message', 'Candidate added successfully!');
        }

        $this->reset(['first_name', 'last_name', 'other_name', 'matric_no', 'position', 'photo', 'election_id', 'editingCandidateId']);
    }


    public function editCandidate($id)
    {
        $candidate = Candidate::findOrFail($id);
        $this->editingCandidateId = $id;
        $this->first_name = $candidate->first_name;
        $this->last_name = $candidate->last_name;
        $this->other_name = $candidate->other_name;
        $this->matric_no = $candidate->matric_no;
        $this->position = $candidate->position;
        $this->election_id = $candidate->election_id;
    }
    public function exportCandidates()
    {
        $candidates = Candidate::with('election')->get();

        $pdf = Pdf::loadView('exports.candidates', compact('candidates'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'candidates.pdf');
    }
    public function deleteCandidate($id)
    {
        Candidate::findOrFail($id)->delete();
        session()->flash('message', 'Candidate deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->status = $candidate->status === 'active' ? 'inactive' : 'active';
        $candidate->save();
    }


    public function render()
    {
        $candidates = Candidate::query()
            ->when($this->search, fn($q) => $q->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%")
                ->orWhere('matric_no', 'like', "%{$this->search}%")
                ->orWhere('position', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $elections = Election::all();

        return view('livewire.admin.candidate-management', compact('candidates', 'elections'))
            ->layout('layouts.admin.app', ['header' => 'Candidate Management']);
    }
}
