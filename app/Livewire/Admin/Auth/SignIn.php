<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SignIn extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (
            Auth::guard('admin')->attempt(
                ['email' => $this->email, 'password' => $this->password],
                $this->remember
            )
        ) {
            session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        $this->addError('email', 'Invalid credentials. Please try again.');
    }

    public function render()
    {
        return view('livewire.admin.auth.sign-in')
            ->layout('layouts.admin.auth');
    }
}
