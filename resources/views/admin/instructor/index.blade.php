@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Instructors</h1>
        <div class="text-end">
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-success mb-3">Create Instructor</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Department</th>
                    {{-- <th>Username</th> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->id }}</td>
                        <td>{{ $instructor->full_name }}</td>
                        <td>{{ $instructor->email }}</td>
                        <td>{{ $instructor->position }}</td>
                        <td>{{ $instructor->department }}</td>
                        {{-- <td>{{ $instructor->username +}}</td> --}}
                        <td>
                            <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST"
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
