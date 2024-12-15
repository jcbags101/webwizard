@extends('instructor.layout')

@section('instructor-content')
<h1 style="margin-top: 20px; font-size:30px">My Classes</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
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
                @if($schoolClasses->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No classes found</td>
                    </tr>
                @else
                    @foreach ($schoolClasses as $schoolClass)
                        <tr>
                            <td>{{ $schoolClass->id }}</td>
                            <td>{{ $schoolClass->section ? $schoolClass->section->name : 'N/A' }}</td>
                            <td>{{ $schoolClass->schedule }}</td>
                            <td>{{ $schoolClass->subject->name }}</td>
                            <td>{{ $schoolClass->instructor->full_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $schoolClass->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $schoolClass->id }}">
                                        <a class="dropdown-item" href="{{ route('instructor.requirements.index', ['class_id' => $schoolClass->id]) }}">
                                            <i class="fas fa-file-alt"></i> View Requirements
                                        </a>
                                        <a class="dropdown-item" href="{{ route('instructor.classes.students', $schoolClass->id) }}">
                                            <i class="fas fa-users"></i> Show Students
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
@endsection
