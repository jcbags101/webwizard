<?php

namespace App\Imports;

use App\Models\ClassRecord;
use Maatwebsite\Excel\Concerns\ToModel;

class ClassRecordsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ClassRecord([
            'student_name' => $row[0],  // Excel/CSV column 1
            'student_id'   => (int) $row[1],  // Excel/CSV column 2
            'grade'        => (int) $row[2],  // Excel/CSV column 3
        ]);
    }
}
