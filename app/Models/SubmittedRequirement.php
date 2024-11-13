<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['requirement_id', 'file', 'instructor_id', 'class_id', 'status', 'remarks', 'edit_status'];


    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}
