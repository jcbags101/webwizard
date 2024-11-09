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
                        Upload Excel/CSV file with columns: Student ID/LRN, First Name, Last Name, Email, Contact Number, Gender
                    </small>
                </div>

                <div class="form-group">
                    <label>{{ __('Current Students') }}</label>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID/LRN</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Gender</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($section->students as $index => $student)
                                    <tr data-student-id="{{ $student->id }}">
                                        <td>
                                            <input type="text" name="existing_students[{{ $index }}][student_id]" 
                                                class="form-control @error('existing_students.'.$index.'.student_id') is-invalid @enderror"
                                                value="{{ old('existing_students.'.$index.'.student_id', $student->student_id) }}" required>
                                            @error('existing_students.'.$index.'.student_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="existing_students[{{ $index }}][first_name]"
                                                class="form-control @error('existing_students.'.$index.'.first_name') is-invalid @enderror"
                                                value="{{ old('existing_students.'.$index.'.first_name', $student->first_name) }}" required>
                                            @error('existing_students.'.$index.'.first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="existing_students[{{ $index }}][last_name]"
                                                class="form-control @error('existing_students.'.$index.'.last_name') is-invalid @enderror"
                                                value="{{ old('existing_students.'.$index.'.last_name', $student->last_name) }}" required>
                                            @error('existing_students.'.$index.'.last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="email" name="existing_students[{{ $index }}][email]"
                                                class="form-control @error('existing_students.'.$index.'.email') is-invalid @enderror"
                                                value="{{ old('existing_students.'.$index.'.email', $student->email) }}" required>
                                            @error('existing_students.'.$index.'.email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="existing_students[{{ $index }}][contact_number]"
                                                class="form-control @error('existing_students.'.$index.'.contact_number') is-invalid @enderror"
                                                value="{{ old('existing_students.'.$index.'.contact_number', $student->contact_number) }}">
                                            @error('existing_students.'.$index.'.contact_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="existing_students[{{ $index }}][gender]" 
                                                class="form-control @error('existing_students.'.$index.'.gender') is-invalid @enderror" required>
                                                <option value="male" {{ old('existing_students.'.$index.'.gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('existing_students.'.$index.'.gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('existing_students.'.$index.'.gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                        
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="updateExistingStudent({{ $student->id }})">
                                                    <i class="fas fa-save"></i> Update
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeExistingStudent(this)">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>
                                            <input type="hidden" name="existing_students[{{ $index }}][id]" value="{{ $student->id }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No students found in this section.</td>
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
                                        <input type="text" name="students[0][student_id]" class="form-control @error('students.0.student_id') is-invalid @enderror" placeholder="Enter student ID" required>
                                        @error('students.0.student_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="students[0][first_name]" class="form-control @error('students.0.first_name') is-invalid @enderror" placeholder="Enter first name" required>
                                        @error('students.0.first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="students[0][last_name]" class="form-control @error('students.0.last_name') is-invalid @enderror" placeholder="Enter last name" required>
                                        @error('students.0.last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="students[0][email]" class="form-control @error('students.0.email') is-invalid @enderror" placeholder="Enter email" required>
                                        @error('students.0.email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" name="students[0][contact_number]" class="form-control @error('students.0.contact_number') is-invalid @enderror" placeholder="Enter contact number" required>
                                        @error('students.0.contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="students[0][gender]" class="form-control @error('students.0.gender') is-invalid @enderror" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error('students.0.gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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

                    function updateExistingStudent(studentId) {
                        console.log('Updating student with ID:', studentId);

                        const studentEntry = document.querySelector(`[data-student-id="${studentId}"]`);
                        
                        // Check if student entry exists
                        if (!studentEntry) {
                            console.error('Student entry not found');
                            alert('Error: Student entry not found');
                            return;
                        }
                        
                        // Create data object
                        const data = {};
                        studentEntry.querySelectorAll('input, select').forEach(input => {
                            // Extract the field name from the input name (e.g., existing_students[0][first_name] -> first_name)
                            const fieldName = input.name.match(/\[([^\]]+)\]$/)[1];
                            data[fieldName] = input.value;
                        });
                        
                        // Send AJAX request to update student
                        fetch(`{{ route('admin.sections.updateStudent', '') }}/${studentId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Student updated successfully',
                                    confirmButtonColor: '#F9A602',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error updating student',
                                    confirmButtonColor: '#F9A602'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!', 
                                text: 'Error updating student',
                                confirmButtonColor: '#F9A602'
                            });
                        });
                    }

                    document.getElementById('upload-btn').addEventListener('click', async function() {
                        const fileInput = document.getElementById('student_file');
                        const file = fileInput.files[0];
                        
                        if (!file) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Please select a file first',
                                confirmButtonColor: '#F9A602'
                            });
                            return;
                        }

                        // Check file extension
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        
                        try {
                            let data;
                            if (['xls', 'xlsx'].includes(fileExtension)) {
                                // Handle Excel files
                                const workbook = await readExcelFile(file);
                                const worksheet = workbook.Sheets[workbook.SheetNames[0]];
                                data = XLSX.utils.sheet_to_json(worksheet);
                            } else if (fileExtension === 'csv') {
                                // Handle CSV files
                                const text = await readFileAsText(file);
                                data = parseCSV(text);
                            } else {
                                throw new Error('Unsupported file format');
                            }

                            // Clear existing students
                            const container = document.getElementById('students-container');
                            container.innerHTML = '';

                            data.forEach((row, index) => {
                                const studentData = {
                                    student_id: row['Student ID/LRN'] || row['student_id'] || '',
                                    first_name: row['First Name'] || row['first_name'] || '',
                                    last_name: row['Last Name'] || row['last_name'] || '',
                                    email: row['Email'] || row['email'] || '',
                                    contact_number: row['Contact Number'] || row['contact_number'] || '',
                                    gender: row['Gender'] || row['gender'] || ''
                                };

                                const studentHtml = `
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
                                                    <input type="text" name="students[${index}][student_id]" class="form-control" value="${studentData.student_id}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="students[${index}][first_name]" class="form-control" value="${studentData.first_name}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="students[${index}][last_name]" class="form-control" value="${studentData.last_name}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="students[${index}][email]" class="form-control" value="${studentData.email}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Contact Number</label>
                                                    <input type="text" name="students[${index}][contact_number]" class="form-control" value="${studentData.contact_number}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select name="students[${index}][gender]" class="form-control" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" ${studentData.gender === 'Male' ? 'selected' : ''}>Male</option>
                                                        <option value="Female" ${studentData.gender === 'Female' ? 'selected' : ''}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                container.insertAdjacentHTML('beforeend', studentHtml);
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Students imported successfully',
                                confirmButtonColor: '#F9A602'
                            });
                        
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.message || 'Failed to process file',
                                confirmButtonColor: '#F9A602'
                            });
                        }
                    });

                    // Helper functions
                    async function readFileAsText(file) {
                        return new Promise((resolve, reject) => {
                            const reader = new FileReader();
                            reader.onload = e => resolve(e.target.result);
                            reader.onerror = e => reject(e);
                            reader.readAsText(file);
                        });
                    }

                    async function readExcelFile(file) {
                        return new Promise((resolve, reject) => {
                            const reader = new FileReader();
                            reader.onload = e => {
                                try {
                                    const data = new Uint8Array(e.target.result);
                                    const workbook = XLSX.read(data, { type: 'array' });
                                    resolve(workbook);
                                } catch (error) {
                                    reject(error);
                                }
                            };
                            reader.onerror = e => reject(e);
                            reader.readAsArrayBuffer(file);
                        });
                    }

                    function parseCSV(text) {
                        const lines = text.split('\n');
                        const headers = lines[0].split(',').map(header => header.trim());
                        const result = [];

                        for (let i = 1; i < lines.length; i++) {
                            if (!lines[i].trim()) continue;
                            
                            const values = lines[i].split(',').map(value => value.trim());
                            const row = {};
                            
                            headers.forEach((header, index) => {
                                row[header] = values[index] || '';
                            });
                            
                            result.push(row);
                        }

                        return result;
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
