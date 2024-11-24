<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'quiz_1',
        'quiz_2',
        'quiz_3',
        'quiz_4',
        'quiz_5',
        'quiz_6',
        'oral_1',
        'oral_2',
        'oral_3',
        'oral_4',
        'oral_5',
        'oral_6',
        'project_1',
        'project_2',
        'project_3',
        'project_4',
        'midterm',
        'final',
        'final_grade',
        'class_id',
        'pre_final_quiz_1',
        'pre_final_quiz_2',
        'pre_final_quiz_3',
        'pre_final_quiz_4',
        'pre_final_quiz_5',
        'pre_final_quiz_6',
        'pre_final_oral_1',
        'pre_final_oral_2',
        'pre_final_oral_3',
        'pre_final_oral_4',
        'pre_final_oral_5',
        'pre_final_oral_6',
        'pre_final_project_1',
        'pre_final_project_2',
        'pre_final_project_3',
        'pre_final_project_4',
        'pre_final_midterm',
        'pre_final_final',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
