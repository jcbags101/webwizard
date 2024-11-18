<div>
    <h2>Hello {{ $studentName }},</h2>
    
    <p>Here are your grades for {{ $className }}:</p>
    
    <table>
        <thead>
            <tr>
                <th>MIDTERM</th>
                <th>FINAL TERM</th>
                <th>FINAL GRADE</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td @if(array_key_exists('midterm', $record) && $record['midterm'] >= 3.0) class="failed" @endif>
                    {{ array_key_exists('midterm', $record) ? number_format($record['midterm'], 1) : '-' }}
                </td>
                <td @if(array_key_exists('final', $record) && $record['final'] >= 3.0) class="failed" @endif>
                    {{ array_key_exists('final', $record) ? number_format($record['final'], 1) : '-' }}
                </td>
                <td @if(array_key_exists('final_grade', $record) && $record['final_grade'] >= 3.0) class="failed" @endif>
                    {{ array_key_exists('final_grade', $record) ? number_format($record['final_grade'], 1) : '-' }}
                </td>
                <td @if(array_key_exists('final_grade', $record) && $record['final_grade'] >= 3.0) class="failed" @endif>
                    {{ array_key_exists('final_grade', $record) ? ($record['final_grade'] >= 3.0 ? 'FAILED' : 'PASSED') : '-' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
