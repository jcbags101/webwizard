@extends('admin.layout')

@section('admin-content')
    <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Update Section') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name', $section->name) }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="school_year">{{ __('School Year') }}</label>
                    <input id="school_year" type="text" class="form-control @error('school_year') is-invalid @enderror"
                        name="school_year" value="{{ old('school_year', $section->school_year) }}" required>
                    @error('school_year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('Current Students') }}</label>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID/LRN</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($section->students as $student)
                                    <tr>
                                        <td>{{ $student->student_id }}</td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->contact_number }}</td>
                                        <td>{{ ucfirst($student->gender) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No students found in this section.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <label>{{ __('Add New Students') }}</label>
                    <div id="students-container">
                        <div class="student-entry border p-3 mb-3">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-danger btn-sm remove-student" onclick="removeStudent(this)">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Student ID/LRN</label>
                                        <input type="text" name="students[0][student_id]" class="form-control" placeholder="Enter student ID">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="students[0][first_name]" class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="students[0][last_name]" class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="students[0][email]" class="form-control" placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" name="students[0][contact_number]" class="form-control" placeholder="Enter contact number">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="students[0][gender]" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-student">
                        {{ __('Add Another Student') }}
                    </button>
                </div>

                <script>
                    let studentCount = 1;
                    document.getElementById('add-student').addEventListener('click', function() {
                        const container = document.getElementById('students-container');
                        const template = document.querySelector('.student-entry').cloneNode(true);
                        
                        // Update input names with new index
                        template.querySelectorAll('input, select').forEach(input => {
                            input.name = input.name.replace('[0]', `[${studentCount}]`);
                            input.value = ''; // Clear values
                        });
                        
                        container.appendChild(template);
                        studentCount++;
                    });

                    function removeStudent(button) {
                        const studentEntry = button.closest('.student-entry');
                        if (document.querySelectorAll('.student-entry').length > 1) {
                            studentEntry.remove();
                        } else {
                            alert('At least one student entry must remain.');
                        }
                    }
                </script>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Section') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
