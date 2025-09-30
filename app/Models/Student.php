<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // extend this
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'other_name',
        'matric_no',
        'phone_number',
        // 'otp', // no longer needed
    ];

    // optional: specify guard if needed
    protected $guard = 'user';


    // Relationships
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function votedInElection($electionId)
    {
        return $this->votes()->where('election_id', $electionId)->exists();
    }
}
