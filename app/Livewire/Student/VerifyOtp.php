<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VerifyOtp extends Component
{
    public $otp;

    protected $rules = [
        'otp' => 'required|digits:6',
    ];

    public function verify()
    {
        $this->validate();

        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('student.login');
        }

        $student = Student::find($studentId);

        if (!$student || $student->otp !== $this->otp) {
            $this->addError('otp', 'Invalid OTP.');
            return;
        }

        if (Carbon::now()->greaterThan($student->otp_expires_at)) {
            $this->addError('otp', 'OTP has expired. Please request a new one.');
            return;
        }

        // Login student
        Auth::guard('user')->login($student);

        // Clear OTP
        $student->otp = null;
        $student->otp_expires_at = null;
        $student->save();

        return redirect()->route('student.dashboard');
    }

    public function render()
    {
        return view('livewire.student.verify-otp')
            ->layout('layouts.student.auth', ['title' => 'Student OTP Verification']);
    }

}
