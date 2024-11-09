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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $instructor->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $instructor->id }}">
                                    <li><a class="dropdown-item" href="{{ route('instructors.edit', $instructor->id) }}">Edit</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.submitted_requirements.index', ['instructor_id' => $instructor->id]) }}">View Requirements</a></li>
                                    <li>
                                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST">
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
