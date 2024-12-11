@extends('admin.layout')

@section('admin-content')
<h1 style="margin-top: 20px; font-size:30px">ALL REQUIREMENTS</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
    <div class="text-end">
        <a href="{{ route('admin.requirements.create') }}" class="btn btn-success mb-3">Create Requirement</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requirements as $requirement)
                <tr>
                    <td>{{ $requirement->id }}</td>
                    <td>{{ $requirement->name }}</td>
                    <td>{{ $requirement->description }}</td>
                    <td>{{ $requirement->formatted_deadline }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $requirement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $requirement->id }}">
                                <li><a class="dropdown-item" href="{{ route('admin.requirements.edit', $requirement->id) }}">Edit</a></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger delete-button" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmationModal" 
                                        data-requirement-id="{{ $requirement->id }}" 
                                        data-requirement-name="{{ $requirement->name }}">
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
                    <span id="deleteRequirementText"></span>
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
            const deleteRequirementText = document.getElementById('deleteRequirementText');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const requirementId = this.dataset.requirementId;
                    const requirementName = this.dataset.requirementName;

                    // Set the modal's text without including the description
                    deleteRequirementText.innerHTML = `Are you sure you want to delete requirement <strong>"${requirementName}"</strong>?`;

                    // Update the form's action URL dynamically
                    deleteForm.action = `/admin/requirements/${requirementId}`;
                });
            });
        });
    </script>
@endsection
