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
                    <th>Actions</th>
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
                        <td>
                            <a href="{{ route('instructor.requirements.index', ['class_id' => $schoolClass->id]) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-file-alt"></i> View Requirements
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
