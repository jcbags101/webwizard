<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'section_id',
        'schedule',
        'subject_id',
        'instructor_id',
    ];

    // Define relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function classRecordItem()
    {
        return $this->hasOne(ClassRecordItem::class, 'class_id');
    }

    public function sharedInstructors()
    {
        return $this->belongsToMany(Instructor::class, 'shared_class_records', 'class_id', 'instructor_id');
    }
}
