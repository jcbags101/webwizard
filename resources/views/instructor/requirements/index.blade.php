@extends('instructor.layout')

@section('instructor-content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1 style="margin-top: 20px; font-size:30px">My Submitted Requirements</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;"> <!-- Added line here -->
    <div class="text-end">
        <a href="{{ route('instructor.requirements.create') }}" class="btn btn-success mb-3">Submit Requirement</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Requirement</th>
                <th>File</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Edit Request Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($requirements->isEmpty())
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
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $submittedRequirement->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton{{ $submittedRequirement->id }}">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('instructor.requirements.edit', $submittedRequirement->id) }}">{{ $submittedRequirement->edit_status === 'approved' ? 'Edit' : 'View' }}</a>
                                    </li>
                                    @if ($submittedRequirement->edit_status === 'pending' || $submittedRequirement->edit_status === 'rejected')
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('instructor.requirements.requestEdit', $submittedRequirement->id) }}">Request
                                                Edit</a>
                                        </li>
                                    @endif
                                    <!-- Delete Button that Triggers Modal -->
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $submittedRequirement->id }}">Delete</button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal{{ $submittedRequirement->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $submittedRequirement->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: linear-gradient(45deg, #FF4500, #DC143C); color: white;">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $submittedRequirement->id }}">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this submitted requirement?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form
                                                action="{{ route('instructor.requirements.destroy', $submittedRequirement->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
