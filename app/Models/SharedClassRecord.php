<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SchoolClass;

class SharedClassRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'instructor_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'class_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
