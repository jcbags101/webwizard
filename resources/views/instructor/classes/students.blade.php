@extends('instructor.layout')

@section('instructor-content')
    <a href="{{ route('instructor.classes.index') }}" class="btn btn-secondary mb-3">Back</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Students in {{ $schoolClass->section->name }} - {{ $schoolClass->subject->name }}</h1>
        <a href="{{ route('instructor.class_records.pdf', ['id' => $schoolClass->id]) }}" class="btn btn-primary mb-3" target="_blank">Generate PDF</a>
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-success me-2" onclick="sendGrades()">
                <i class="fas fa-envelope"></i> Send Grades to Students
            </button>
            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="bi bi-plus-lg"></i> Add Student
            </button>
            <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#shareInstructorModal">
                <i class="fas fa-share-alt"></i> Share to Other Instructor
            </button>

            <!-- Share Instructor Modal -->
            <div class="modal fade" id="shareInstructorModal" tabindex="-1" aria-labelledby="shareInstructorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="shareInstructorModalLabel">Share to Other Instructor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="shareInstructorForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="instructor" class="form-label">Select Instructor</label>
                                    <select class="form-select" id="instructor" name="instructor_email" required>
                                        <option value="">Choose an instructor...</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->email }}">{{ $instructor->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" onclick="shareWithInstructor()">Share</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <nav class="nav-tabs mb-4">
                <div class="d-flex align-items-center justify-content-center bg-white rounded-top p-2 shadow-sm">
                    <button class="btn btn-outline-primary rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".gradeColumn" aria-expanded="false" onclick="hideOthers('gradeColumn')">
                        <i class="fas fa-pen-alt me-2"></i>
                        <span class="fw-bold">Quizzes</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>

                    <button class="btn btn-outline-success rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".oralColumn" aria-expanded="false" onclick="hideOthers('oralColumn')">
                        <i class="fas fa-comments me-2"></i>
                        <span class="fw-bold">Oral Participation</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>

                    <button class="btn btn-outline-info rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".projectColumn" aria-expanded="false" onclick="hideOthers('projectColumn')">
                        <i class="fas fa-project-diagram me-2"></i>
                        <span class="fw-bold">Project</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>

                    <button class="btn btn-outline-warning rounded-pill px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".termExamColumn" aria-expanded="false" onclick="hideOthers('termExamColumn')">
                        <i class="fas fa-file-alt me-2"></i>
                        <span class="fw-bold">Term Exam</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                </div>
            </nav>

            <div class="collapse gradeColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="col">
                                    <label class="form-label fw-semibold mb-1">Quiz {{ $i }} Items</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                               name="quiz{{ $i }}_items" 
                                               class="form-control quiz-items" 
                                               min="1" 
                                               step="1" 
                                               required
                                               value="{{ $schoolClass->classRecordItem?->{"quiz_{$i}"} }}"
                                               placeholder="Enter items">
                                        <span class="input-group-text">items</span>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Items</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="collapse oralColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="col">
                                    <label class="form-label fw-semibold mb-1">Oral {{ $i }} Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="oral{{ $i }}_items" 
                                           class="form-control oral-items" 
                                           min="1" 
                                           step="1" 
                                           required
                                           value="{{ $schoolClass->classRecordItem?->{"oral_{$i}"} }}"
                                           placeholder="Enter items">
                                    <span class="input-group-text">items</span>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Items</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="collapse projectColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-3 row-cols-md-2 g-3">
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="col">
                                <label class="form-label fw-semibold mb-1">Project {{ $i }} Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="project{{ $i }}_items" 
                                           class="form-control project-items" 
                                           min="1" 
                                           step="1" 
                                           required
                                           value="{{ $schoolClass->classRecordItem?->{"project_{$i}"} }}"
                                           placeholder="Enter items">
                                    <span class="input-group-text">items</span>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Items</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="collapse termExamColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-1">Midterm Exam Items</label>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       name="midterm_exam_items" 
                                       class="form-control term-exam-items" 
                                       min="1" 
                                       step="1" 
                                       required
                                       value="{{ $schoolClass->classRecordItem?->{"midterm"} }}"
                                       placeholder="Enter items">
                                <span class="input-group-text">items</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold mb-1">Final Exam Items</label>
                            <div class="input-group input-group-sm">
                                <input type="number" 
                                       name="final_exam_items" 
                                       class="form-control term-exam-items" 
                                       min="1" 
                                       step="1" 
                                       required
                                       value="{{ $schoolClass->classRecordItem?->{"final"} }}"
                                       placeholder="Enter items">
                                <span class="input-group-text">items</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Save Items</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped" id="studentsTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>LRN</th>
                    
                </tr>
            </thead>
            <tbody>
                @if($students->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No students found</td>
                    </tr>
                @else
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->getClassRecord($schoolClass->id)->final_grade ?? 0 }}</td>
                            <td class="collapse gradeColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Quiz {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="quiz{{ $i }}" class="form-control form-control-sm quiz-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'quiz_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="quiz{{ $i }}_percentage" class="form-control form-control-sm quiz-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" class="form-control form-control-sm quiz-total" style="width: 80px;" readonly>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm quiz-total-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">30%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="collapse oralColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Oral {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="oral{{ $i }}" class="form-control form-control-sm oral-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'oral_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="oral{{ $i }}_percentage" class="form-control form-control-sm oral-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                          <label class="small">Total</label>
                                          <div class="d-flex gap-2">
                                              <div>
                                                  <input type="number" class="form-control form-control-sm oral-total" style="width: 80px;" readonly>
                                                  <small class="text-muted">Score</small>
                                              </div>
                                              <div>
                                                  <input type="number" class="form-control form-control-sm oral-total-percentage" style="width: 80px;" readonly>
                                                  <small class="text-muted">Percentage</small>
                                              </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="collapse projectColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="me-3">
                                                <label class="small">Project {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="project{{ $i }}" class="form-control form-control-sm project-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'project_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="project{{ $i }}_percentage" class="form-control form-control-sm project-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" class="form-control form-control-sm project-total" style="width: 80px;" readonly>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm project-total-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">Percentage</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="collapse termExamColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="small">Midterm</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="midterm" class="form-control form-control-sm term-exam-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'midterm'} ?? 0 }}">
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="midterm_percentage" class="form-control form-control-sm term-exam-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">EQU</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <label class="small">Finals</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="final" class="form-control form-control-sm term-exam-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'final'} ?? 0 }}">
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="final_percentage" class="form-control form-control-sm term-exam-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">Percentage ({{ $student->finals_items > 0 ? number_format((float)$student->finals / $student->finals_items * 100, 2) : 0 }}%)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
              </tbody>
        </table>
    </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addStudentForm"  method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hideOthers(currentId) {
            const allColumns = ['gradeColumn', 'oralColumn', 'projectColumn', 'termExamColumn'];
            allColumns.forEach(id => {
                if (id !== currentId) {
                    const element = document.getElementsByClassName(id);
                    if (element && element.length > 0) {
                        Array.from(element).forEach(el => {
                            el.classList.remove('show');
                        });
                    }
                }
            });
        }

        let shareModal;
        
        document.addEventListener('DOMContentLoaded', function() {
            shareModal = new bootstrap.Modal(document.getElementById('shareInstructorModal'));
            // Get modal element and create instance

            // Handle form submission
            document.getElementById('addStudentForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                try {
                    const response = await fetch('{{ route("instructor.students.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            student_id: formData.get('student_id'),
                            first_name: formData.get('first_name'),
                            last_name: formData.get('last_name'),
                            email: formData.get('email'),
                            class_id: formData.get('class_id')
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Student added successfully!',
                            icon: 'success',
                            confirmButtonColor: '#F9A602'
                        }).then((result) => {
                            window.location.href = window.location.href;
                        });
                        // // Add new row to table
                        // const tbody = document.querySelector('#studentsTable tbody');
                        // const newRow = document.createElement('tr');
                        
                        // newRow.innerHTML = `
                        //     <td>${data.student.id}</td>
                        //     <td>${data.student.first_name} ${data.student.last_name}</td>
                        //     <td>${data.student.email}</td>
                        //     <td>${data.student.lrn}</td>
                        //     <td class="collapse gradeColumn">
                        //         <!-- Add grade columns structure -->

                        //     </td>
                        // `;
                        
                        // if (tbody.querySelector('tr')) {
                        //     tbody.insertBefore(newRow, tbody.firstChild);
                        // } else {
                        //     tbody.innerHTML = newRow.outerHTML;
                        // }

                        // // Close modal
                        // modal.hide();
                        // this.reset();
                        
                        // // Manual cleanup
                        // document.body.classList.remove('modal-open');
                        // const backdrop = document.querySelector('.modal-backdrop');
                        // if (backdrop) backdrop.remove();
                        // document.body.removeAttribute('style');
                        // modalElement.style.display = 'none';
                        
                        // // Show success message
                        // Swal.fire({
                        //     title: 'Success!',
                        //     text: 'Student added successfully!',
                        //     icon: 'success',
                        //     confirmButtonColor: '#F9A602'
                        // });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error adding student: ' + data.message,
                            icon: 'error',
                            confirmButtonColor: '#F9A602'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error adding student. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#F9A602'
                    });
                }
            });

            // Handle modal hidden event
            modalElement.addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
                document.body.removeAttribute('style');
                modalElement.style.display = 'none';
            });
        });

        async function sendGrades() {
            try {
                const response = await fetch('{{ route("instructor.classes.students.send-grades", $schoolClass->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Grades have been sent to students via email',
                        icon: 'success',
                        confirmButtonColor: '#F9A602'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to send grades',
                        icon: 'error',
                        confirmButtonColor: '#F9A602'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to send grades. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#F9A602'
                });
            }
        }

        async function shareWithInstructor() {
            const instructor = document.getElementById('instructor').value;
            if (!instructor) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validation Error', 
                    text: 'Please select an instructor before sharing',
                    confirmButtonColor: '#F9A602'
                });
                return;
            }

            try {
                const response = await fetch('{{ route('instructor.classes.share', ['id' => $schoolClass->id]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        instructor_email: instructor
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message || 'Successfully shared with instructor',
                        confirmButtonColor: '#F9A602'
                    });

                    console.log('shareModal', shareModal);

                    // Close modal
                    if (shareModal) {
                        shareModal.hide();
                    }
                } else {
                    throw new Error(data.message || 'Failed to share with instructor');
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error sharing with instructor',
                    confirmButtonColor: '#F9A602'
                });
            }
        }
    </script>
@endsection
