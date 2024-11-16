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
            <table class="table table-striped">
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
                            <td>{{ $student->getClassRecord($schoolClass->id)->final_grade}}</td>
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
        
        document.addEventListener('DOMContentLoaded', function() {
            // For each student row

          const transmutationTable = {
                100: 1.0, 99: 1.1, 98: 1.2, 97: 1.3, 96: 1.4, 95: 1.5, 94: 1.6, 93: 1.6, 92: 1.7,
                91: 1.7, 90: 1.8, 89: 1.8, 88: 1.9, 87: 1.9, 86: 2.0, 85: 2.0, 84: 2.1, 83: 2.1,
                82: 2.2, 81: 2.2, 80: 2.3, 79: 2.3, 78: 2.4, 77: 2.4, 76: 2.5, 75: 2.5, 74: 2.6,
                73: 2.6, 72: 2.7, 71: 2.7, 70: 2.8, 69: 2.8, 68: 2.9, 67: 2.9, 66: 3.0, 65: 3.0,
                64: 3.1, 63: 3.1, 62: 3.2, 61: 3.2, 60: 3.3, 59: 3.3, 58: 3.4, 57: 3.4, 56: 3.5,
                55: 3.5, 54: 3.6, 53: 3.6, 52: 3.7, 51: 3.7, 50: 3.8, 49: 3.8, 48: 3.9, 47: 3.9,
                46: 4.0, 45: 4.0, 44: 4.1, 43: 4.1, 42: 4.2, 41: 4.2, 40: 4.3, 39: 4.3, 38: 4.4,
                37: 4.4, 36: 4.5, 35: 4.5, 34: 4.6, 33: 4.6, 32: 4.7, 31: 4.7, 30: 4.8, 29: 4.8,
                28: 4.9, 27: 4.9, 26: 5.0
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

                    const total = calculatePercentageAndTransmutation(totalScore, totalItems);
                    if (totalInput) {
                        totalInput.value = total;
                    }


                    const totalPercentage = total * rate;
                    if (totalPercentageInput) {
                        totalPercentageInput.value = totalPercentage;
                    }
                }

                // Add event listeners
                [...inputs, ...itemInputs].forEach(input => {
                    input.addEventListener('input', updateCalculations);
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
            });

        });
    </script>
@endsection
