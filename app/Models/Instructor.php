<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'email', 'position', 'department', 'username', 'password'];

    public function submittedRequirements()
    {
        return $this->hasMany(SubmittedRequirement::class, 'instructor_id');
    }

    /**
     * Get the user associated with the instructor.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
