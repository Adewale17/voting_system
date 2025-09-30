<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $matric_no;
    public $phone_number;

    protected $rules = [
        'matric_no' => 'required|string',
        'phone_number' => 'required|string',
    ];

    public function login()
    {
        $this->validate();

        // Check if student exists
        $student = Student::where('matric_no', $this->matric_no)
            ->where('phone_number', $this->phone_number)
            ->first();

        if (!$student) {
            $this->addError('matric_no', 'Matric number or phone number is incorrect.');
            return;
        }

        // Log in the student using the "user" guard
        Auth::guard('user')->login($student);

        // Redirect to dashboard
        return redirect()->route('student.dashboard');
    }

    public function render()
    {
        return view('livewire.student.login')
            ->layout('layouts.student.auth', ['title' => 'Student Login']);
    }
}
