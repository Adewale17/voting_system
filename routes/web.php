<?php

use App\Livewire\Admin\Auth\SignIn;
use App\Livewire\Admin\CandidateManagement;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ElectionManagement;
use App\Livewire\Admin\Results;
use App\Livewire\Admin\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Student\Login;
use App\Livewire\Student\VerifyOtp;
use App\Http\Livewire\Student\VoteDashboard;
use App\Livewire\Student\Board;
use App\Livewire\Student\Result;
use App\Livewire\Student\VoteBoard;

Route::get('/login', SignIn::class)->name('login');
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', UserManagement::class)->name('users');
    Route::get('/candidates', CandidateManagement::class)->name('candidates');
    Route::get('/elections', ElectionManagement::class)->name('elections');
    Route::get('admin/results', Results::class)->name('results');
});

Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    return redirect('/login');
})->name('admin.logout');
// Routes accessible only to non-logged-in students

Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('student.login');
});

// Authenticated student routes
Route::middleware('auth:user')->group(function () {
    Route::get('/dashbord', Board::class)->name('student.dashboard');
    Route::get('/vote', VoteBoard
        ::class)->name('student.vote');
    Route::get('/result', Result
        ::class)->name('student.result');

});
Route::post('/logout', function () {
    Auth::guard('user')->logout();
    return redirect('/');
})->name('logout');


