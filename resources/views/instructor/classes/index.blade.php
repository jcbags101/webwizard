@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1>All Classes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Section</th>
                    <th>Schedule</th>
                    <th>Subject</th>
                    <th>Instructor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schoolClasses as $schoolClass)
                    <tr>
                        <td>{{ $schoolClass->id }}</td>
                        <td>{{ $schoolClass->section }}</td>
                        <td>{{ $schoolClass->schedule }}</td>
                        <td>{{ $schoolClass->subject->name }}</td>
                        <td>{{ $schoolClass->instructor->full_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
