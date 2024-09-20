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
                        <td>{{ $schoolClass->section }}</td>
                        <td>{{ $schoolClass->schedule }}</td>
                        <td>{{ $schoolClass->subject->name }}</td>
                        <td>{{ $schoolClass->instructor->full_name }}</td>
                        <td>
                            <a href="{{ route('admin.classes.edit', $schoolClass->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.classes.destroy', $schoolClass->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
