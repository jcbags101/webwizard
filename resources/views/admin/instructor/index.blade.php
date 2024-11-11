@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Instructors</h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="text-end">
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-success mb-3">Create Instructor</a>
            <button type="button" class="btn btn-primary mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#notifyModal">
                Notify Requirements
            </button>

            <!-- Notify Modal -->
            <div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notifyModalLabel">Notify Instructors</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.notify.instructors') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="message" class="form-label">Notification Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Send Notification</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
