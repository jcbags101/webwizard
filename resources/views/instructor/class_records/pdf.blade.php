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

        th,
        td {
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
            <strong style="display: inline-block; width: 120px;">MIS CODE</strong>: {{ $schoolClass->subject->code }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">SUBJECT</strong>: {{ $schoolClass->subject->name }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">DESCRIPTION</strong>:
            {{ $schoolClass->subject->description }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">UNIT</strong>: {{ $schoolClass->subject->units }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">TIME/DAY/ROOM</strong>: {{ $schoolClass->schedule }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">INSTRUCTOR</strong>:
            {{ $schoolClass->instructor->name }}
        </div>
        <div class="details-row">
            <strong style="display: inline-block; width: 120px;">DATE AND TIME</strong>: {{ $currentDateTime }}
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
            @foreach ($classRecords as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->student->student_id }}</td>
                    <td>{{ $record->student->last_name }}, {{ $record->student->first_name }}</td>
                    <td>{{ $record->student->course }}</td>
                    <td>{{ $record->student->year }}</td>
                    <td @if ($record->midterm_grade >= 3.0) class="failed" @endif>
                        {{ number_format($record->midterm_grade, 1) }}</td>
                    <td @if ($record->prefinal_grade >= 3.0) class="failed" @endif>
                        {{ number_format($record->prefinal_grade, 1) }}</td>
                    <td @if ($record->final_grade >= 3.0) class="failed" @endif>
                        {{ number_format($record->final_grade, 1) }}</td>
                    <td @if ($record->final_grade >= 3.0) class="failed" @endif>
                        {{ $record->final_grade >= 3.0 ? 'FAILED' : 'PASSED' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: 0px; border: none;">
        <tr>
            <td style="border: none; width: 50%; vertical-align: top;">
                <p><strong>Prepared and Submitted By:</strong></p>
                <br><br><br>
                <p style="margin-bottom: 0;"><strong>{{ $schoolClass->instructor->full_name }}</strong></p>
                <p style="margin-top: 0;">Associate Professor V, College of Technology</p>
                <p style="margin-top: 0;">CTU-NAGA EXTENSION CAMPUS</p>
                <br><br>
                <p><strong>Reviewed and Certified True and Correct:</strong></p>
                <br><br><br>
                <p style="margin-bottom: 0;"><strong>AL D. HORTEZA, LPT, Ph.D.</strong></p>
                <p style="margin-top: 0;">Campus Head of Instruction</p>
                <p style="margin-top: 0;">CTU-NAGA EXTENSION CAMPUS</p>
            </td>
            <td style="border: none; width: 50%; vertical-align: top;">
                <p><strong>Noted and Checked By:</strong></p>
                <br><br><br>
                <p style="margin-bottom: 0;"><strong>MARIA CHRISTINA A. FLORES, LPT, MSME</strong></p>
                <p style="margin-top: 0;">Chairman, College of Technology</p>
                <p style="margin-top: 0;">CTU-NAGA EXTENSION CAMPUS</p>
                <br><br>
                <p><strong>Received By:</strong></p>
                <br><br><br>
                <p style="margin-bottom: 0;"><strong>JOVEL R. CADAVOS, LPT</strong></p>
                <p style="margin-top: 0;">Registrar Designate</p>
                <p style="margin-top: 0;">CTU-NAGA EXTENSION CAMPUS</p>
            </td>
        </tr>
    </table>
</body>

</html>
