@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1>All Submitted Requirements</h1>
        <div class="text-end">
            <a href="{{ route('instructor.requirements.create') }}" class="btn btn-success mb-3">Submit
            Requirement</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requirement</th>
                    <th>File</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Edit Request Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($requirements->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No submitted requirements found</td>
                    </tr>
                @else
                    @foreach ($requirements as $submittedRequirement)
                        <tr>
                            <td>{{ $submittedRequirement->id }}</td>
                            <td>{{ $submittedRequirement->requirement->name }}</td>
                            <td><a href="{{ asset('storage/' . $submittedRequirement->file) }}" target="_blank">View File</a></td>
                            <td>
                                @if($submittedRequirement->class->section)
                                    {{ $submittedRequirement->class->section->name }}
                                @else
                                    <span class="text-muted">No Section</span>
                                @endif
                                -
                                {{ $submittedRequirement->class->subject ? $submittedRequirement->class->subject->name : 'N/A' }}
                            </td>
                            <td>
                                @if ($submittedRequirement->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($submittedRequirement->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif ($submittedRequirement->status === 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>{{ $submittedRequirement->remarks ?? 'No remarks' }}</td>
                            <td>
                                @if ($submittedRequirement->edit_status === 'request_submitted')
                                    <span class="badge bg-warning text-dark">Request Submitted</span>
                                @elseif ($submittedRequirement->edit_status === 'pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif ($submittedRequirement->edit_status === 'approved') 
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($submittedRequirement->edit_status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $submittedRequirement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $submittedRequirement->id }}">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('instructor.requirements.edit', $submittedRequirement->id) }}">View</a>
                                        </li>
                                        @if ($submittedRequirement->edit_status === 'pending' || $submittedRequirement->edit_status === 'rejected')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('instructor.requirements.requestEdit', $submittedRequirement->id) }}">Request Edit</a>
                                        </li>
                                        @endif
                                        <li>
                                            <form action="{{ route('instructor.requirements.destroy', $submittedRequirement->id) }}" method="POST">
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
                @endif
            </tbody>
        </table>
    </div>
@endsection
