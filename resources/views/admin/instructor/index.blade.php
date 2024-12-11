@extends('admin.layout')

@section('admin-content')
<h1 style="margin-top: 20px; font-size:30px">ALL Instructors</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="text-end">
            @if(auth()->user()->user_type !== 'Chairman')
                <a href="{{ route('admin.instructors.create') }}" class="btn btn-success mb-3">Create Instructor</a>
            @endif
                <button type="button" class="btn btn-primary mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#notifyAllModal">
                    Notify All Requirements
                </button>

            <!-- Notify All Modal -->
            <div class="modal fade" id="notifyAllModal" tabindex="-1" aria-labelledby="notifyAllModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: orange; color: white;">
                            <h5 class="modal-title" id="notifyAllModalLabel">Notify All Instructors</h5>
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

            <!-- Individual Notify Modal -->
            <div class="modal fade" id="notifyInstructorModal" tabindex="-1" aria-labelledby="notifyInstructorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: orange; color: white;">
                            <h5 class="modal-title" id="notifyInstructorModalLabel">Notify Instructor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="notifyInstructorForm" action="{{ route('admin.notify.instructor') }}" method="POST">
                            @csrf
                            <input type="hidden" name="instructor_id" id="notifyInstructorId">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="individual_message" class="form-label">Notification Message</label>
                                    <textarea class="form-control" id="individual_message" name="message" rows="3" required></textarea>
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
        <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(45deg, #FF4500, #DC143C); color: white;">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteInstructorName"></strong>?
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
                                    @if(auth()->user()->user_type !== 'Chairman')
                                        <li><a class="dropdown-item" href="{{ route('instructors.edit', $instructor->id) }}">Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.submitted_requirements.index', ['instructor_id' => $instructor->id]) }}">View Requirements</a></li>
                                    @endif
                                    <li>
                                        <button class="dropdown-item notify-instructor" data-bs-toggle="modal" data-bs-target="#notifyInstructorModal" data-instructor-id="{{ $instructor->id }}" data-instructor-name="{{ $instructor->full_name }}">
                                            Notify Instructor
                                        </button>
                                    </li>
                                    @if(auth()->user()->user_type !== 'Chairman')
                                   <li>
                                        <button type="button" class="dropdown-item text-danger delete-button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmationModal" 
                                            data-instructor-id="{{ $instructor->id }}" 
                                            data-instructor-name="{{ $instructor->full_name }}">
                                            Delete
                                        </button>
                                    </li>

                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifyButtons = document.querySelectorAll('.notify-instructor');
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteForm = document.getElementById('deleteForm');
        const deleteInstructorName = document.getElementById('deleteInstructorName');
        
        notifyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const instructorId = this.dataset.instructorId;  // Using dataset property
                const instructorName = this.dataset.instructorName;
                
                // Set the hidden input value
                const hiddenInput = document.getElementById('notifyInstructorId');
                hiddenInput.value = instructorId;
                
                // Update modal title
                document.getElementById('notifyInstructorModalLabel').textContent = `Notify ${instructorName}`;
            });
        });
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const instructorId = this.dataset.instructorId;
                const instructorName = this.dataset.instructorName;

                // Update the modal's text
                deleteInstructorName.textContent = instructorName;

                // Update the form's action URL
                deleteForm.action = `/instructors/${instructorId}`;
            });
        });
        });
    </script>
    
@endsection
