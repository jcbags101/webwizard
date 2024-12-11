@extends('admin.layout')

@section('admin-content')

<h1 style="margin-top: 20px; font-size:30px">ALL SUBMITTED REQUIREMENTS</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
    <div class="mb-3">
        <a href="{{ route('admin.submitted_requirements.index', ['edit_status' => 'request_submitted']) }}"
            class="btn btn-primary {{ request('edit_status') == 'request_submitted' ? 'active' : '' }}" >
            Show Edit Requests
        </a>
        @if (request()->has('edit_status'))
            <a href="{{ route('admin.submitted_requirements.index') }}" class="btn btn-secondary">Show All</a>
        @endif

        <div class="float-end">
            <form action="{{ route('admin.submitted_requirements.index') }}" method="GET" class="d-inline">
                @if (request('edit_status'))
                    <input type="hidden" name="edit_status" value="{{ request('edit_status') }}">
                @endif
                <select name="instructor_id" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                    <option value="">All Instructors</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}"
                            {{ request('instructor') == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->full_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    @if ($requirements->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requirement</th>
                    <th>File</th>
                    <th>Instructor</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requirements as $submittedRequirement)
                    <tr>
                        <td>{{ $submittedRequirement->id }}</td>
                        <td>{{ $submittedRequirement->requirement->name }}</td>
                        <td><a href="{{ asset('storage/' . $submittedRequirement->file) }}" target="_blank">View File</a>
                        </td>
                        <td>{{ $submittedRequirement->instructor->full_name }}</td>
                        <td>
                            @if ($submittedRequirement->is_late)
                                <span class="badge bg-danger">Late</span>
                            @elseif ($submittedRequirement->status === 'pending')
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
                        <td>{{ $submittedRequirement->created_at->format('M d, Y h:ia') }}</td>
                        <td>{{ $submittedRequirement->remarks ?? 'No remarks' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $submittedRequirement->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton{{ $submittedRequirement->id }}">
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.submitted_requirements.edit', $submittedRequirement->id) }}">Edit</a>
                                    </li>
                                    @if ($submittedRequirement->is_late && $submittedRequirement->message)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.submitted_requirements.late_message', $submittedRequirement->id) }}">
                                                View Late Submission Message
                                            </a>
                                        </li>
                                    @endif
                                    @if ($submittedRequirement->edit_status === 'request_submitted')
                                        <li>
                                            <form
                                                action="{{ route('admin.submitted_requirements.approveEdit', $submittedRequirement->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item">Approve Edit Request</button>
                                            </form>
                                        </li>
                                    @endif
                                    <li>
                                        <button type="button" class="dropdown-item text-danger delete-button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmationModal" 
                                            data-submission-id="{{ $submittedRequirement->id }}" 
                                            data-instructor-name="{{ $submittedRequirement->instructor->full_name }}">
                                            Delete
                                        </button>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(45deg, #FF4500, #DC143C); color: white;">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="deleteSubmissionText"></span>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            const deleteForm = document.getElementById('deleteForm');
            const deleteSubmissionText = document.getElementById('deleteSubmissionText');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const submissionId = this.dataset.submissionId;
                    const instructorName = this.dataset.instructorName;

                    // Set the modal's text
                    deleteSubmissionText.innerHTML= `Are you sure you want to delete this submission from <strong>${instructorName}</strong>?`;

                    // Update the form's action URL dynamically
                    deleteForm.action = `/admin/submitted_requirements/${submissionId}`;
                });
            });
        });
    </script>
@endsection
