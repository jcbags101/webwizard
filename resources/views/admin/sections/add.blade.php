@extends('admin.layout')

@section('admin-content')
    
    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Create Section</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.sections.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="school_year">{{ __('School Year') }}</label>
                    <input id="school_year" type="text" class="form-control @error('school_year') is-invalid @enderror"
                        name="school_year" value="{{ old('school_year') }}" required>
                    @error('school_year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="semester">{{ __('Semester') }}</label>
                    <select id="semester" class="form-control @error('semester') is-invalid @enderror" 
                            name="semester" required>
                        <option value="">Select Semester</option>
                        <option value="First Semester" {{ old('semester') == 'First Semester' ? 'selected' : '' }}>First Semester</option>
                        <option value="Second Semester" {{ old('semester') == 'Second Semester' ? 'selected' : '' }}>Second Semester</option>
                    </select>
                    @error('semester')
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
                        Accepted formats: .xlsx, .xls, .csv. File should contain columns: Student ID/LRN, First Name, Last Name, Email
                    </small>
                    @error('student_file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('Add Students') }}</label>
                    <div id="students-container">
                        <div class="student-entry border p-3 mb-3">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-danger btn-sm remove-student" onclick="removeStudent(this)">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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

                    document.getElementById('upload-btn').addEventListener('click', async function() {
                        const fileInput = document.getElementById('student_file');
                        const file = fileInput.files[0];
                        
                        console.log({file});
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Student ID/LRN</label>
                                                    <input type="text" name="students[${index}][student_id]" class="form-control" value="${studentData.student_id}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" name="students[${index}][first_name]" class="form-control" value="${studentData.first_name}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input type="text" name="students[${index}][last_name]" class="form-control" value="${studentData.last_name}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="students[${index}][email]" class="form-control" value="${studentData.email}" required>
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

                    async function parseCSV(text) {
                        const rows = text.split('\n');
                        const headers = rows[0].split(',').map(header => header.trim());
                        return rows.slice(1)
                            .filter(row => row.trim())
                            .map(row => {
                                const values = row.split(',').map(value => value.trim());
                                return headers.reduce((obj, header, index) => {
                                    obj[header] = values[index] || '';
                                    return obj;
                                }, {});
                            });
                    }
                </script>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                        {{ __('Add Section') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
