@extends('admin.layout')

@section('admin-content')
<h1 style="margin-top: 20px; font-size:30px">ALL SUBJECTS</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
        <div class="text-end">
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-success mb-3">Create Subject</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Code</th>
                    <th>Units</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->units }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $subject->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $subject->id }}">
                                    <li><a class="dropdown-item" href="{{ route('admin.subjects.edit', $subject->id) }}">Edit</a></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger delete-button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmationModal" 
                                            data-subject-id="{{ $subject->id }}" 
                                            data-subject-name="{{ $subject->name }}"
                                            data-subject-description="{{ $subject->description }}">
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(45deg, #FF4500, #DC143C); color: white;">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong id="deleteSubjectDetails"></strong>?
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
            const deleteSubjectDetails = document.getElementById('deleteSubjectDetails');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const subjectId = this.dataset.subjectId;
                    const subjectName = this.dataset.subjectName;
                    const subjectDescription = this.dataset.subjectDescription;

                    // Format and set the modal's text
                    deleteSubjectDetails.textContent = `"${subjectName} - ${subjectDescription}"`;

                    // Update the form's action URL dynamically
                    deleteForm.action = `/admin/subjects/${subjectId}`;
                });
            });
        });
    </script>
@endsection
