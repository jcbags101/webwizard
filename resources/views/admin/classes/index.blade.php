@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Classes</h1>
        <div class="text-end">
            <a href="{{ route('admin.classes.create') }}" class="btn btn-success mb-3">Create Class</a>
        </div>
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
                        <td>{{ $schoolClass->section ? $schoolClass->section->name : 'N/A' }}</td>
                        <td>{{ $schoolClass->schedule }}</td>
                        <td>{{ $schoolClass->subject->name }}</td>
                        <td>{{ $schoolClass->instructor->full_name }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $schoolClass->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $schoolClass->id }}">
                                    <li><a class="dropdown-item" href="{{ route('admin.classes.edit', $schoolClass->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('admin.classes.destroy', $schoolClass->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
