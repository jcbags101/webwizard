<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gradesheet Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .details {
            margin-bottom: 20px;
        }
        .details-row {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        .failed {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <h4>Republic of the Philippines</h4>
        <h3>CEBU TECHNOLOGICAL UNIVERSITY</h3>
        <h4>NAGA EXTENSION CAMPUS</h4>
        <p>Central Poblacion, City of Naga, Cebu, Philippines</p>
        <p>Website: http://www.ctu.edu.ph E-mail: ctunagaextensioncampus@gmail.com</p>
        <h3>COLLEGE OF TECHNOLOGY</h3>
        <h2>GRADESHEET SUMMARY</h2>
        <h4>First Semester, AY {{ now()->format('Y') }}-{{ now()->addYear()->format('Y') }}</h4>
    </div>

    <div class="details">
        <div class="details-row">
            <strong>MIS CODE:</strong> {{ $schoolClass->subject->code }}
        </div>
        <div class="details-row">
            <strong>SUBJECT:</strong> {{ $schoolClass->subject->name }}
        </div>
        <div class="details-row">
            <strong>DESCRIPTION:</strong> {{ $schoolClass->subject->description }}
        </div>
        <div class="details-row">
            <strong>UNIT:</strong> {{ $schoolClass->subject->units }}
        </div>
        <div class="details-row">
            <strong>TIME/DAY/ROOM:</strong> {{ $schoolClass->schedule }}
        </div>
        <div class="details-row">
            <strong>INSTRUCTOR:</strong> {{ $schoolClass->instructor->name }}
        </div>
        <div class="details-row">
            <strong>DATE AND TIME:</strong> {{ $currentDateTime }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID NUMBER</th>
                <th>NAMES OF THE STUDENTS</th>
                <th>COURSE</th>
                <th>YEAR</th>
                <th>MIDTERM</th>
                <th>FINAL TERM</th>
                <th>FINAL GRADE</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->student->student_id }}</td>
                <td>{{ $record->student->last_name }}, {{ $record->student->first_name }}</td>
                <td>{{ $record->student->course }}</td>
                <td>{{ $record->student->year }}</td>
                <td @if($record->midterm >= 3.0) class="failed" @endif>{{ number_format($record->midterm, 1) }}</td>
                <td @if($record->final >= 3.0) class="failed" @endif>{{ number_format($record->final, 1) }}</td>
                <td @if($record->final_grade >= 3.0) class="failed" @endif>{{ number_format($record->final_grade, 1) }}</td>
                <td @if($record->final_grade >= 3.0) class="failed" @endif>
                    {{ $record->final_grade >= 3.0 ? 'FAILED' : 'PASSED' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
