<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['action', 'submitted_requirement_id', 'changes'];

    public function submittedRequirement()
    {
        return $this->belongsTo(SubmittedRequirement::class);
    }
}