<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRecordItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
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
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}