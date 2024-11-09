@extends('admin.layout')

@section('admin-content')
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>


    <div class="container">
        <h1>All Submitted Requirements</h1>
        @if($requirements->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requirement</th>
                        <th>File</th>
                        <th>Class</th>
                        <th>Instructor</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requirements as $submittedRequirement)
                        <tr>
                            <td>{{ $submittedRequirement->id }}</td>
                            <td>{{ $submittedRequirement->requirement->name }}</td>
                            <td><a href="{{ asset('storage/' . $submittedRequirement->file) }}" target="_blank">View File</a></td>
                            <td>{{ $submittedRequirement->class->section }}</td>
                            <td>{{ $submittedRequirement->instructor->full_name }}</td>
                            <td>
                                @if ($submittedRequirement->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($submittedRequirement->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif ($submittedRequirement->status === 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @elseif ($submittedRequirement->status === 'chairman_approved')
                                    <span class="badge bg-info">Chairman Approved</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>{{ $submittedRequirement->remarks ?? 'No remarks' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $submittedRequirement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $submittedRequirement->id }}">
                                        <li><a class="dropdown-item" href="{{ route('admin.submitted_requirements.edit', $submittedRequirement->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('admin.submitted_requirements.destroy', $submittedRequirement->id) }}" method="POST">
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
        @else
            <div class="alert alert-info">
                No submitted requirements found.
            </div>
        @endif
    </div>
@endsection
