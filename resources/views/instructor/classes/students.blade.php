@extends('instructor.layout')

@section('instructor-content')
    <a href="{{ route('instructor.classes.index') }}" class="btn btn-secondary mb-3">Back</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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
            <nav class="nav-tabs">
                <div class="d-flex align-items-center justify-content-center bg-white rounded-top p-2 shadow-sm">
                    <button class="btn btn-outline-danger rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#midtermContent" aria-expanded="false" onclick="mainHideOthers('midtermContent')">
                        <i class="fas fa-file-alt me-2"></i>
                        <span class="fw-bold">Midterm</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
    
                    <button class="btn btn-outline-dark rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#preFinalContent" aria-expanded="false" onclick="mainHideOthers('preFinalContent')">
                        <i class="fas fa-file-alt me-2"></i>
                        <span class="fw-bold">Pre-Final</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                </div>
            </nav>
        </div>
        <div class="mb-4 collapse" id="midtermContent">
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
                            <input type="hidden" name="term_type" id="termTypeInput" value="midterm">
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
                            <input type="hidden" name="term_type" id="termTypeInput" value="midterm">
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
                                    <label class="form-label fw-semibold mb-1">Prelim Exam Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="midterm_exam_items" 
                                           class="form-control term-exam-items" 
                                           min="1" 
                                           step="1" 
                                           value="{{ $schoolClass->classRecordItem?->{"midterm"} }}"
                                           placeholder="Enter items">
                                    <span class="input-group-text">items</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-1">Midterm Exam Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="final_exam_items" 
                                           class="form-control term-exam-items" 
                                           min="1" 
                                           step="1" 
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

        <div class="mb-4 collapse" id="preFinalContent">
            <nav class="nav-tabs mb-4">
                <div class="d-flex align-items-center justify-content-center bg-white rounded-top p-2 shadow-sm">
                    <button class="btn btn-outline-primary rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".preFinalGradeColumn" aria-expanded="false" onclick="hideOthers('preFinalGradeColumn')">
                        <i class="fas fa-pen-alt me-2"></i>
                        <span class="fw-bold">Pre Final - Quizzes</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
        
                    <button class="btn btn-outline-success rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".preFinalOralColumn" aria-expanded="false" onclick="hideOthers('preFinalOralColumn')">
                        <i class="fas fa-comments me-2"></i>
                        <span class="fw-bold">Pre Final - Oral Participation</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
        
                    <button class="btn btn-outline-info rounded-pill me-3 px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".preFinalProjectColumn" aria-expanded="false" onclick="hideOthers('preFinalProjectColumn')">
                        <i class="fas fa-project-diagram me-2"></i>
                        <span class="fw-bold">Pre Final - Project</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
        
                    <button class="btn btn-outline-warning rounded-pill px-4 py-2" type="button" data-bs-toggle="collapse" data-bs-target=".preFinalTermExamColumn" aria-expanded="false" onclick="hideOthers('preFinalTermExamColumn')">
                        <i class="fas fa-file-alt me-2"></i>
                        <span class="fw-bold">Pre Final - Term Exam</span>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                </div>
            </nav>
        
            <div class="collapse preFinalGradeColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="term_type" id="termTypeInput" value="pre_final">
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="col">
                                    <label class="form-label fw-semibold mb-1">Quiz {{ $i }} Items</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                               name="pre_final_quiz{{ $i }}_items" 
                                               class="form-control pre-final-quiz-items" 
                                               min="1" 
                                               step="1" 
                                               value="{{ $schoolClass->classRecordItem?->{"pre_final_quiz_{$i}"} }}"
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
        
            <div class="collapse preFinalOralColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="term_type" id="termTypeInput" value="pre_final">
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="col">
                                    <label class="form-label fw-semibold mb-1">Oral {{ $i }} Items</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                               name="pre_final_oral{{ $i }}_items" 
                                               class="form-control pre-final-oral-items" 
                                               min="1" 
                                               step="1" 
                                               value="{{ $schoolClass->classRecordItem?->{"pre_final_oral_{$i}"} }}"
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

            <div class="collapse preFinalProjectColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="term_type" id="termTypeInput" value="pre_final">
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row row-cols-3 row-cols-md-2 g-3">
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="col">
                                    <label class="form-label fw-semibold mb-1">Project {{ $i }} Items</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                               name="pre_final_project{{ $i }}_items" 
                                               class="form-control pre-final-project-items" 
                                               min="1" 
                                               step="1" 
                                               value="{{ $schoolClass->classRecordItem?->{"pre_final_project_{$i}"} }}"
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

            <div class="collapse preFinalTermExamColumn">
                <div class="card card-body p-3 bg-light">
                    <form action="{{ route('instructor.class-record-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="term_type" id="termTypeInput" value="pre_final">
                        <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-1">Semi Final Exam Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="pre_final_midterm_exam_items" 
                                           class="form-control pre-final-term-exam-items" 
                                           min="1" 
                                           step="1" 
                                           value="{{ $schoolClass->classRecordItem?->{"pre_final_midterm"} }}"
                                           placeholder="Enter items">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold mb-1">Final Exam Items</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" 
                                           name="pre_final_final_exam_items" 
                                           class="form-control pre-final-term-exam-items" 
                                           min="1" 
                                           step="1" 
                                           value="{{ $schoolClass->classRecordItem?->{"pre_final_final"} }}"
                                           placeholder="Enter items">
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
                    <th>MidTerm Grade</th>
                    <th>PreFinal Grade</th>
                    <th>Final Grade</th>
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
                            <td>{{ $student->getClassRecord($schoolClass->id)->midterm_grade ?? 0 }}</td>
                            <td>{{ $student->getClassRecord($schoolClass->id)->prefinal_grade ?? 0 }}</td>
                            <td>{{ $student->getClassRecord($schoolClass->id)->final_grade ?? 0 }}</td>
                            <td class="collapse gradeColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <input type="hidden" name="term_type" class="termTypeInput" value="midterm">
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
                                    <input type="hidden" name="term_type" class="termTypeInput" value="midterm">
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
                                    <input type="hidden" name="term_type" class="termTypeInput" value="midterm">
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
                                    <input type="hidden" name="term_type" class="termTypeInput" value="midterm">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="small">Prelim</label>
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
                                            <label class="small">Midterm</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="final" class="form-control form-control-sm term-exam-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'final'} ?? 0 }}">
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="final_percentage" class="form-control form-control-sm term-exam-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">EQU</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control form-control-sm term-exam-total" style="width: 80px;" readonly>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <label class="small">Percentage</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control form-control-sm term-exam-total-percentage" style="width: 80px;" readonly>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>

                            <td class="collapse preFinalGradeColumn">
                                <!-- Pre-Final Grades Section -->
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <input type="hidden" name="term_type" class="termTypeInput" value="pre_final">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Pre-Final Quiz {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="pre_final_quiz{{ $i }}" class="form-control form-control-sm pre-final-quiz-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'pre_final_quiz_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="pre_final_quiz{{ $i }}_percentage" class="form-control form-control-sm pre-final-quiz-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-quiz-total" style="width: 80px;" readonly>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-quiz-total-percentage" style="width: 80px;" readonly>
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
                            <td class="collapse preFinalOralColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <input type="hidden" name="term_type" class="termTypeInput" value="pre_final">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Pre-Final Oral {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="pre_final_oral{{ $i }}" class="form-control form-control-sm pre-final-oral-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'pre_final_oral_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="pre_final_oral{{ $i }}_percentage" class="form-control form-control-sm pre-final-oral-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-oral-total" style="width: 80px;" readonly>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-oral-total-percentage" style="width: 80px;" readonly>
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

                            <td class="collapse preFinalProjectColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <input type="hidden" name="term_type" class="termTypeInput" value="pre_final">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="me-3">
                                                <label class="small">Pre-Final Project {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="pre_final_project{{ $i }}" class="form-control form-control-sm pre-final-project-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->{'pre_final_project_'.$i} ?? 0 }}">
                                                        <small class="text-muted">Score</small>
                                                    </div>
                                                    <div>
                                                        <input type="number" name="pre_final_project{{ $i }}_percentage" class="form-control form-control-sm pre-final-project-percentage" style="width: 80px;" readonly>
                                                        <small class="text-muted">EQU</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-project-total" style="width: 80px;" readonly>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm pre-final-project-total-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">20%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-save"></i> Save All
                                        </button>
                                    </div>
                                </form>
                            </td>

                            <td class="collapse preFinalTermExamColumn">
                                <form action="{{ route('instructor.class_records.store') }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <input type="hidden" name="term_type" class="termTypeInput" value="pre_final">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="small">Semi-Final Midterm</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="pre_final_midterm" class="form-control form-control-sm pre-final-term-exam-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->pre_final_midterm ?? 0 }}">
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="pre_final_midterm_percentage" class="form-control form-control-sm pre-final-term-exam-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">20%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <label class="small">Final Exam</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="pre_final_final" class="form-control form-control-sm pre-final-term-exam-input" style="width: 80px;" min="0" max="100" step="1" required value="{{ $student->getClassRecord($schoolClass->id)->pre_final_final ?? 0 }}">
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="pre_final_final_percentage" class="form-control form-control-sm pre-final-term-exam-percentage" style="width: 80px;" readonly>
                                                    <small class="text-muted">20%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <label class="small">Total</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control form-control-sm pre-final-term-exam-total" style="width: 80px;" readonly>
                                                <small class="text-muted">40%</small>
                                            </div>
                                        </div>

                                        <div class="me-3">
                                            <label class="small">Percentage</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control form-control-sm pre-final-term-exam-total-percentage" style="width: 80px;" readonly>
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
            const allColumns = ['gradeColumn', 'oralColumn', 'projectColumn', 'termExamColumn', 'preFinalGradeColumn', 'preFinalOralColumn', 'preFinalProjectColumn', 'preFinalTermExamColumn'];
            allColumns.forEach(id => {
                if (id !== currentId) {
                    console.log(id);
                    const element = document.getElementsByClassName(id);
                    if (element && element.length > 0) {
                        Array.from(element).forEach(el => {
                            el.classList.remove('show');
                        });
                    }
                }
            });

            
        }

        document.addEventListener('DOMContentLoaded', function() {
            const midtermBtn = document.querySelector('[data-bs-target="#midtermContent"]');
            const preFinalBtn = document.querySelector('[data-bs-target="#preFinalContent"]');
            const termTypeInputs = document.getElementsByClassName('termTypeInput');
            
            // Add click event listeners
            midtermBtn.addEventListener('click', function() {
                Array.from(termTypeInputs).forEach(input => {
                    input.value = 'midterm';
                });
            });

            preFinalBtn.addEventListener('click', function() {
                Array.from(termTypeInputs).forEach(input => {
                    input.value = 'pre_final';
                });

                console.log(termTypeInputs);
            });
            
            const transmutationTable = {
                100: 1.0, 99: 1.1, 98: 1.2, 97: 1.3, 96: 1.4, 95: 1.5, 94: 1.6, 93: 1.6, 92: 1.7,
                91: 1.7, 90: 1.8, 89: 1.8, 88: 1.9, 87: 1.9, 86: 2.0, 85: 2.0, 84: 2.1, 83: 2.1,
                82: 2.2, 81: 2.2, 80: 2.3, 79: 2.3, 78: 2.4, 77: 2.4, 76: 2.5, 75: 2.5, 74: 2.6,
                73: 2.6, 72: 2.6, 71: 2.6, 70: 2.6, 69: 2.7, 68: 2.7, 67: 2.7, 66: 2.7, 65: 2.7,
                64: 2.8, 63: 2.8, 62: 2.8, 61: 2.8, 60: 2.8, 59: 2.9, 58: 2.9, 57: 2.9, 56: 2.9,
                55: 2.9, 54: 3.0, 53: 3.0, 52: 3.0, 51: 3.0, 50: 3.0, 49: 3.1, 48: 3.1, 47: 3.1,
                46: 3.2, 45: 3.2, 44: 3.3, 43: 3.3, 42: 3.3, 41: 3.3, 40: 3.3, 39: 3.4, 38: 3.4,
                37: 3.5, 36: 3.5, 35: 3.5, 34: 3.6, 33: 3.6, 32: 3.6, 31: 3.7, 30: 3.7, 29: 3.8,
                28: 3.8, 27: 3.8, 26: 3.8, 25: 3.9, 24: 3.9, 23: 3.9, 22: 4.0, 21: 4.0, 20: 4.1,
                19: 4.1, 18: 4.1, 17: 4.2, 16: 4.2, 15: 4.3, 14: 4.3, 13: 4.4, 12: 4.4, 11: 4.4,
                10: 4.5, 9: 4.5, 8: 4.6, 7: 4.6, 6: 4.7, 5: 4.7, 4: 4.8, 3: 4.8, 2: 4.9, 1: 4.9,
                0: 5.0
            };

            const rates = {
                quiz: 0.3,
                oral: 0.2,
                project: 0.1,
                term: 0.4
            }

            function calculatePercentageAndTransmutation(score, totalItems) {
                if (!score || !totalItems) return '';
                const percentage = Math.round((score / totalItems) * 100);
                // If percentage is less than minimum in table (26), return 5.0
                if (percentage < 26) return 5.0;
                // If percentage is greater than 100, return 1.0
                if (percentage > 100) return 1.0;
                return transmutationTable[percentage];
            }

            const quizItems = document.querySelectorAll('.quiz-items');
            const oralItems = document.querySelectorAll('.oral-items');
            const projectItems = document.querySelectorAll('.project-items');
            const termItems = document.querySelectorAll('.term-exam-items');
            const preFinalQuizItems = document.querySelectorAll('.pre-final-quiz-items');
            const preFinalOralItems = document.querySelectorAll('.pre-final-oral-items');
            const preFinalProjectItems = document.querySelectorAll('.pre-final-project-items');
            const preFinalTermItems = document.querySelectorAll('.pre-final-term-exam-items');

            // Handle quiz calculations for each row
            // Helper function to handle calculations for a specific type of assessment
            function handleAssessmentCalculations(row, {
                inputs, percentages, totalInput, totalPercentageInput, itemInputs, rate
            }) {
                if (!inputs.length) return; // Skip if not a student row
                
                function updateCalculations() {
                    console.log('updateCalculations');
                    // Calculate individual scores
                    inputs.forEach((input, index) => {
                        const score = Number(input.value) || 0;
                        const totalItems = Number(itemInputs[index]?.value) || 0;
                        const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                        if (percentages[index]) {
                            percentages[index].value = transmutedGrade;
                        }
                    });

                    console.log(inputs);
                    // Calculate totals
                    const totalScore = Array.from(inputs).reduce((sum, input) => 
                        sum + (Number(input.value) || 0), 0);
                    const totalItems = Array.from(itemInputs).reduce((sum, input) => 
                        sum + (Number(input.value) || 0), 0);

                    const validPercentages = Array.from(percentages).filter(input => input.value !== null && input.value !== '');
                    const total = validPercentages.length > 0 ? 
                        validPercentages.reduce((sum, input) => sum + (Number(input.value) || 0), 0) / validPercentages.length : 0;
                    if (totalInput) {
                        totalInput.value = Math.round(total * 10) / 10;
                    }


                    const totalPercentage = total * rate;
                    if (totalPercentageInput) {
                        totalPercentageInput.value = Math.round(totalPercentage * 100) / 100;
                    }
                }

                // Add event listeners
                [...inputs, ...itemInputs].forEach(input => {
                    input && input.addEventListener('input', updateCalculations);
                });

                updateCalculations();
            }

            // Process each student row
            document.querySelectorAll('tr').forEach(row => {
                // Handle quizzes
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.quiz-input'),
                    percentages: row.querySelectorAll('.quiz-percentage'), 
                    totalInput: row.querySelector('.quiz-total'),
                    totalPercentageInput: row.querySelector('.quiz-total-percentage'),
                    itemInputs: quizItems,
                    rate: rates.quiz
                });

                // Handle oral assessments  
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.oral-input'),
                    percentages: row.querySelectorAll('.oral-percentage'),
                    totalInput: row.querySelector('.oral-total'),
                    totalPercentageInput: row.querySelector('.oral-total-percentage'),
                    itemInputs: oralItems,
                    rate: rates.oral
                });

                // Handle projects
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.project-input'),
                    percentages: row.querySelectorAll('.project-percentage'),
                    totalInput: row.querySelector('.project-total'),
                    totalPercentageInput: row.querySelector('.project-total-percentage'),
                    itemInputs: projectItems,
                    rate: rates.project
                });

                // Handle term exams
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.term-exam-input'),
                    percentages: row.querySelectorAll('.term-exam-percentage'),
                    totalInput: row.querySelector('.term-exam-total'),
                    totalPercentageInput: row.querySelector('.term-exam-total-percentage'),
                    itemInputs: termItems,
                    rate: rates.term
                });


                // Handle pre-final quizzes
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.pre-final-quiz-input'),
                    percentages: row.querySelectorAll('.pre-final-quiz-percentage'),
                    totalInput: row.querySelector('.pre-final-quiz-total'),
                    totalPercentageInput: row.querySelector('.pre-final-quiz-total-percentage'),
                    itemInputs: preFinalQuizItems,
                    rate: rates.quiz
                });

                // Handle pre-final orals
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.pre-final-oral-input'),
                    percentages: row.querySelectorAll('.pre-final-oral-percentage'),
                    totalInput: row.querySelector('.pre-final-oral-total'),
                    totalPercentageInput: row.querySelector('.pre-final-oral-total-percentage'),
                    itemInputs: preFinalOralItems,
                    rate: rates.oral
                });

                // Handle pre-final projects
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.pre-final-project-input'),
                    percentages: row.querySelectorAll('.pre-final-project-percentage'),
                    totalInput: row.querySelector('.pre-final-project-total'),
                    totalPercentageInput: row.querySelector('.pre-final-project-total-percentage'),
                    itemInputs: preFinalProjectItems,
                    rate: rates.project
                });


                // Handle pre-final term exams
                handleAssessmentCalculations(row, {
                    inputs: row.querySelectorAll('.pre-final-term-exam-input'),
                    percentages: row.querySelectorAll('.pre-final-term-exam-percentage'),
                    totalInput: row.querySelector('.pre-final-term-exam-total'),
                    totalPercentageInput: row.querySelector('.pre-final-term-exam-total-percentage'),
                    itemInputs: preFinalTermItems,
                    rate: rates.term
                });
            });

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

        function mainHideOthers(targetClass) {
            // Get all collapse elements
            const midtermContent = document.getElementById('midtermContent');
            const preFinalContent = document.getElementById('preFinalContent');

            // If target is preFinalContent, hide midtermContent
            if (targetClass === 'preFinalContent') {
                if (midtermContent.classList.contains('show')) {
                    midtermContent.classList.remove('show');
                }
            }
            // If target is midtermContent, hide preFinalContent
            else if (targetClass === 'midtermContent') {
                if (preFinalContent.classList.contains('show')) {
                    preFinalContent.classList.remove('show');
                }
            }
        }
    </script>
@endsection
