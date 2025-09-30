<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;


class UserManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = '';
    public $first_name, $last_name, $other_name, $matric_no, $phone_number;
    public $csvFile;
    public $deleteId = null;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'other_name' => 'nullable|string|max:255',
        'matric_no' => 'required|string|max:50|unique:students,matric_no',
        'phone_number' => 'required|string|max:20',
    ];

    public function exportStudents()
{
    $students = Student::all();

    $pdf = Pdf::loadView('exports.students', compact('students'))
              ->setPaper('a4', 'landscape');

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, 'students.pdf');
}

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addStudent()
    {
        $this->validate();

        Student::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_name' => $this->other_name,
            'matric_no' => $this->matric_no,
            'phone_number' => $this->phone_number,
            'status' => 'active',
        ]);

        session()->flash('message', 'Student added successfully!');
        $this->reset(['first_name', 'last_name', 'other_name', 'matric_no', 'phone_number']);
    }

    public function uploadCsv()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt',
        ]);

        $path = $this->csvFile->getRealPath();
        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        while ($row = fgetcsv($file)) {
            Student::updateOrCreate(
                ['matric_no' => $row[3]],
                [
                    'first_name' => $row[0],
                    'last_name' => $row[1],
                    'other_name' => $row[2],
                    'phone_number' => $row[4],
                    'status' => 'active',
                ]
            );
        }

        fclose($file);
        session()->flash('message', 'CSV uploaded successfully!');
        $this->csvFile = null;
    }
public function confirmDelete($id)
{
    $this->deleteId = $id;
    $this->dispatchBrowserEvent('show-delete-confirmation');
}
    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Student deleted successfully!');
    }

    public function render()
    {
        $students = Student::query()
            ->when($this->search, fn($q) => $q->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%")
                ->orWhere('matric_no', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user-management', compact('students'))->layout('layouts.admin.app', ['header' => 'User Management']);
    }
}
