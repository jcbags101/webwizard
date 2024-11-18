<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentGradesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $className;
    public $record;

    public function __construct($studentName, $className, $record)
    {
        $this->studentName = $studentName;
        $this->className = $className;
        $this->record = $record;
    }

    public function build()
    {
        return $this->view('emails.student-grades')
                    ->subject('Your Class Grades');
    }
}
