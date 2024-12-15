<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SubmittedRequirement extends Model
{
    use HasFactory;

    protected $fillable = ['requirement_id', 'file', 'instructor_id', 'class_id', 'status', 'remarks', 'edit_status', 'is_late', 'message'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($submittedRequirement) {
            Log::info('SubmittedRequirement created: ', $submittedRequirement->toArray());
            static::logActivity('created', $submittedRequirement);
        });

        static::updated(function ($submittedRequirement) {
            Log::info('SubmittedRequirement updated: ', $submittedRequirement->toArray());
            static::logActivity('updated', $submittedRequirement);
        });

        static::deleted(function ($submittedRequirement) {
            Log::info('SubmittedRequirement deleted: ', $submittedRequirement->toArray());
            static::logActivity('deleted', $submittedRequirement);
        });
    }

    // Method to log activity in the database
    protected static function logActivity($action, $submittedRequirement)
    {
        $changes = null;

        if ($action === 'updated') {
            // Get the original attributes before the update
            $original = $submittedRequirement->getOriginal();
            // Get the updated attributes
            $updated = $submittedRequirement->getAttributes();
            // Prepare changes with previous and future values
            $changes = [];
            foreach ($updated as $key => $value) {
                if (array_key_exists($key, $original) && $original[$key] !== $value) {
                    $changes[] = sprintf(
                        'Field "%s" changed from "%s" to "%s"',
                        $key,
                        $original[$key],
                        $value
                    );
                }
            }
        }

        ActivityLog::create([
            'action' => $action,
            'submitted_requirement_id' => $submittedRequirement->id,
            'changes' => $changes ? implode('; ', $changes) : null, // Store changes as a human-readable string
        ]);
    }

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

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'submitted_requirement_id');
    }
}
