@extends('admin.layout')

@section('admin-content')
<h1 style="margin-top: 20px; font-size:30px">ALL SECTIONS</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
    <div class="text-end">
        <a href="{{ route('admin.sections.create') }}" class="btn btn-success mb-3">Create Section</a>
    </div>
    @if($sections->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr>
                        <td>{{ $section->id }}</td>
                        <td>{{ $section->name }}</td>
                        <td>{{ $section->school_year }}</td>
                        <td>{{ $section->semester }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                        id="dropdownMenuButton{{ $section->id }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $section->id }}">
                                    <li><a class="dropdown-item" href="{{ route('admin.sections.edit', $section->id) }}">Edit</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.sections.showStudents', $section->id) }}">View Students</a></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger delete-button" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteConfirmationModal" 
                                                data-section-id="{{ $section->id }}" 
                                                data-section-info="{{ $section->name }} - {{ $section->semester }} ({{ $section->school_year }})">
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
            No sections found.
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
                    <span id="deleteSectionText"></span>
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
            const deleteSectionText = document.getElementById('deleteSectionText');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const sectionId = this.dataset.sectionId;
                    const sectionInfo = this.dataset.sectionInfo;

                    // Set the modal's text
                    deleteSectionText.innerHTML = `Are you sure you want to delete <strong>"${sectionInfo}"</strong>?`;

                    // Update the form's action URL dynamically
                    deleteForm.action = `/admin/sections/${sectionId}`;
                });
            });
        });
    </script>
@endsection
