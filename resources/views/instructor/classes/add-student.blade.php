@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Add Student to {{ $schoolClass->subject->name }} - {{ $schoolClass->section->name }}</span>
                    <a href="{{ route('instructor.classes.students', ['id' => $schoolClass->id]) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('instructor.classes.students.store', ['id' => $schoolClass->id]) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- File Upload Section -->
                        <div class="form-group mb-4">
                            <label>{{ __('Import Students from Excel/CSV') }}</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('student_file') is-invalid @enderror" 
                                       id="student_file" name="student_file" 
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <button class="btn btn-outline-secondary" type="button" id="upload-btn">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                            <small class="form-text text-muted">
                                Accepted formats: .xlsx, .xls, .csv. File should contain columns: Student ID/LRN, First Name, Last Name, Email
                            </small>
                            @error('student_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Manual Student Entry Section -->
                        <div class="form-group">
                            <label>{{ __('Add Students') }}</label>
                            <div id="students-container">
                                <div class="student-entry border p-3 mb-3">
                                    <div class="mb-3">
                                        <label for="student" class="form-label">Select Student</label>
                                        <select class="form-select @error('student_id') is-invalid @enderror" id="student" name="student_id" required>
                                            <option value="">Choose a student...</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}">
                                                    {{ $student->full_name }} ({{ $student->lrn }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-student">
                                {{ __('Add Another Student') }}
                            </button>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                Add Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for file handling -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    // ... Add the same JavaScript code from the reference implementation ...
</script>
@endsection
