@extends('admin.layout')

@section('admin-content')
<h1 style="margin-top: 20px; font-size:30px">ALL Classes</h1>
<hr style="margin-bottom:20px; border: 0.5px solid black;">
    <div class="text-end">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-success mb-3">Create Class</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Section</th>
                <th>Schedule</th>
                <th>Subject</th>
                <th>Instructor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schoolClasses as $schoolClass)
                <tr>
                    <td>{{ $schoolClass->id }}</td>
                    <td>{{ $schoolClass->section ? $schoolClass->section->name : 'N/A' }}</td>
                    <td>{{ $schoolClass->schedule }}</td>
                    <td>{{ $schoolClass->subject->name }}-{{ $schoolClass->subject->description }}</td>
                    <td>{{ $schoolClass->instructor->full_name }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $schoolClass->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $schoolClass->id }}">
                                <li><a class="dropdown-item" href="{{ route('admin.classes.edit', $schoolClass->id) }}">Edit</a></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger delete-button" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmationModal" 
                                        data-class-id="{{ $schoolClass->id }}" 
                                        data-class-section="{{ $schoolClass->section ? $schoolClass->section->name : 'N/A' }}" 
                                        data-class-subject="{{ $schoolClass->subject->name }}"
                                        data-class-description="{{ $schoolClass->subject->description }}">
                                        
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
                    <span id="deleteClassText"></span>
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
            const deleteClassText = document.getElementById('deleteClassText');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const classId = this.dataset.classId;
                    const classSection = this.dataset.classSection;
                    const classSubject = this.dataset.classSubject;

                   
                    deleteClassText.innerHTML = `Are you sure you want to delete the class for section <strong>${classSection}</strong> with the subject <strong>${classSubject}</strong>?`;

                    
                    deleteForm.action = `/admin/classes/${classId}`;
                });
            });
        });
    </script>
@endsection
