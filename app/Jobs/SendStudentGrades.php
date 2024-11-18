<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\StudentGradesMail;
use Illuminate\Support\Facades\Mail;

class SendStudentGrades implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $className;
    protected $record;

    public function __construct($student, $className, $record)
    {
        $this->student = $student;
        $this->className = $className;
        $this->record = $record;
    }

    public function handle()
    {
        Mail::to($this->student->email)->send(new StudentGradesMail(
            $this->student->first_name . ' ' . $this->student->last_name,
            $this->className,
            $this->record
        ));
    }
}
