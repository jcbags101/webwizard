<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'first_name' => $row[0],  // Excel/CSV column 1
            'last_name' => $row[1],  // Excel/CSV column 2
            'student_id' => $row[2],  // Excel/CSV column 3
            'email' => $row[3],  // Excel/CSV column 4
        ]);
    }
}
