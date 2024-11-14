@extends('instructor.layout')

@section('instructor-content')
    <a href="{{ route('instructor.classes.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="container">
        <h1>Students in {{ $schoolClass->section->name }} - {{ $schoolClass->subject->name }}</h1>
        <div class="table-responsive">
            <table class="table table-striped">
        </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>LRN</th>
                    <th class="position-relative">
                        <button class="btn btn-link text-decoration-none w-100 d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#gradeColumn" aria-expanded="false">
                            <span class="fw-bold">Quizzes</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                            <i class="fas fa-arrows-left-right text-muted small ms-2" title="Scroll horizontally to see more" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Scroll sidewards to see more quizzes"></i>
                        </button>
                    
                        <div class="collapse show mt-3" id="gradeColumn">
                            <div class="card card-body p-3 bg-light">
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
                                                       placeholder="Enter items">
                                                <span class="input-group-text">items</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </th>
                    <th class="position-relative">
                        <button class="btn btn-link text-decoration-none w-100 d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#oralColumn" aria-expanded="false">
                            <span class="fw-bold">Oral Participation</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                            <i class="fas fa-arrows-left-right text-muted small ms-2" title="Scroll horizontally to see more" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Scroll sidewards to see more oral scores"></i>
                        </button>
                    
                        <div class="collapse show mt-3" id="oralColumn">
                            <div class="card card-body p-3 bg-light">
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
                                                       placeholder="Enter items">
                                                <span class="input-group-text">items</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </th>
                    <th class="position-relative">
                        <button class="btn btn-link text-decoration-none w-100 d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#projectColumn" aria-expanded="false">
                            <span class="fw-bold">Project</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                            <i class="fas fa-arrows-left-right text-muted small ms-2" title="Scroll horizontally to see more" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Scroll sidewards to see more project scores"></i>
                        </button>
                    
                        <div class="collapse show mt-3" id="projectColumn">
                            <div class="card card-body p-3 bg-light">
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
                                                       placeholder="Enter items">
                                                <span class="input-group-text">items</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </th>
                    <th class="position-relative">
                        <button class="btn btn-link text-decoration-none w-100 d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#termExamColumn" aria-expanded="false">
                            <span class="fw-bold">Term Exam</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        
                        <div class="collapse show mt-3" id="termExamColumn">
                            <div class="card card-body p-3 bg-light">
                                <div class="col g-3">
                                    <div class="col">
                                        <label class="form-label fw-semibold mb-1">Midterm Exam Items</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" 
                                                   name="midterm_exam_items" 
                                                   class="form-control term-exam-items" 
                                                   min="1" 
                                                   step="1" 
                                                   required
                                                   placeholder="Enter items">
                                            <span class="input-group-text">items</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="form-label fw-semibold mb-1">Final Exam Items</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" 
                                                   name="final_exam_items" 
                                                   class="form-control term-exam-items" 
                                                   min="1" 
                                                   step="1" 
                                                   required
                                                   placeholder="Enter items">
                                            <span class="input-group-text">items</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
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
                            <td>{{ $student->lrn }}</td>
                            <td class="collapse show" id="gradeColumn">
                                <form action="{{ route('instructor.classes.students.update-grades', $student->id) }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Quiz {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="quiz{{ $i }}" class="form-control form-control-sm quiz-input" style="width: 80px;" min="0" max="100" step="1" required>
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
                            <td class="collapse show" id="oralColumn">
                                <form action="{{ route('instructor.classes.students.update-grades', $student->id) }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="me-3">
                                                <label class="small">Oral {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="oral{{ $i }}" class="form-control form-control-sm oral-input" style="width: 80px;" min="0" max="100" step="1" required>
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
                            <td class="collapse show" id="projectColumn">
                                <form action="{{ route('instructor.classes.students.update-grades', $student->id) }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="me-3">
                                                <label class="small">Project {{ $i }}</label>
                                                <div class="d-flex gap-2">
                                                    <div>
                                                        <input type="number" name="project{{ $i }}" class="form-control form-control-sm project-input" style="width: 80px;" min="0" max="100" step="1" required>
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
                            <td class="collapse show" id="termExamColumn">
                                <form action="{{ route('instructor.classes.students.update-grades', $student->id) }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="small">Midterm</label>
                                            <div class="d-flex gap-2">
                                                <div>
                                                    <input type="number" name="midterm" class="form-control form-control-sm term-exam-input" style="width: 80px;" min="0" max="100" step="1" required>
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
                                                    <input type="number" name="finals" class="form-control form-control-sm term-exam-input" style="width: 80px;" min="0" max="100" step="1" required>
                                                    <small class="text-muted">Score</small>
                                                </div>
                                                <div>
                                                    <input type="number" name="finals_percentage" class="form-control form-control-sm term-exam-percentage" style="width: 80px;" readonly>
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
            document.querySelectorAll('tr').forEach(row => {
                const quizInputs = row.querySelectorAll('.quiz-input');
                const quizPercentages = row.querySelectorAll('.quiz-percentage');
                const totalInput = row.querySelector('.quiz-total');
                const totalPercentageInput = row.querySelector('.quiz-total-percentage');

                console.log(quizInputs, quizItems);
                // Skip if not a student row (no quiz inputs)
                if (!quizInputs.length) return;

                function updateQuizCalculations() {
                    // Calculate for quizzes
                    quizInputs.forEach((input, index) => {
                        const score = Number(input.value) || 0;
                        console.log(quizItems[index], quizItems);
                        const totalItems = Number(quizItems[index].value) || 0;
                        const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                        quizPercentages[index].value = transmutedGrade;
                    });

                    calculateQuizTotal();
                }

                function calculateQuizTotal() {
                    let total = 0;
                    quizInputs.forEach(input => {
                        total = (total + (Number(input.value) || 0)) / quizInputs.length;
                    });
                    totalInput.value = total;

                    // Calculate total percentage
                    let totalPercentage = 0;
                    quizPercentages.forEach(item => {
                        totalPercentage += Number(item.value) || 0;
                    });
                    
                    totalPercentageInput.value = totalPercentage;
                }

                quizInputs.forEach(input => {
                    input.addEventListener('input', updateQuizCalculations);
                });

                quizItems.forEach(input => {
                    input.addEventListener('input', updateQuizCalculations);
                });
            });

            // Handle oral calculations for each row
            document.querySelectorAll('tr').forEach(row => {
                const oralInputs = row.querySelectorAll('.oral-input');
                const oralPercentages = row.querySelectorAll('.oral-percentage');
                const oralTotalInput = row.querySelector('.oral-total');
                const oralTotalPercentageInput = row.querySelector('.oral-total-percentage');

                // Skip if not a student row (no oral inputs)
                if (!oralInputs.length) return;

                function updateOralCalculations() {
                    // Calculate for orals
                    oralInputs.forEach((input, index) => {
                        const score = Number(input.value) || 0;
                        const totalItems = Number(oralItems[index].value) || 0;
                        const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                        oralPercentages[index].value = transmutedGrade;
                    });

                    calculateOralTotal();
                }

                function calculateOralTotal() {
                    let oralTotal = 0;
                    oralInputs.forEach(input => {
                        oralTotal = (oralTotal + (Number(input.value) || 0)) / oralInputs.length;
                    });
                    oralTotalInput.value = oralTotal;

                    // Calculate total percentage for orals
                    let totalOralPercentage = 0;
                    oralPercentages.forEach(item => {
                        totalOralPercentage += Number(item.value) || 0;
                    });

                    oralTotalPercentageInput.value = totalOralPercentage;
                }

                oralInputs.forEach(input => {
                    input.addEventListener('input', updateOralCalculations);
                });

                oralItems.forEach(input => {
                    input.addEventListener('input', updateOralCalculations);
                });
            });

            // Handle project calculations for each row
            document.querySelectorAll('tr').forEach(row => {
                const projectInputs = row.querySelectorAll('.project-input');
                const projectPercentages = row.querySelectorAll('.project-percentage');
                const projectTotalInput = row.querySelector('.project-total');
                const projectTotalPercentageInput = row.querySelector('.project-total-percentage');

                // Skip if not a student row (no project inputs)
                if (!projectInputs.length) return;

                function updateProjectCalculations() {
                    // Calculate for projects
                    projectInputs.forEach((input, index) => {
                        const score = Number(input.value) || 0;
                        const totalItems = Number(projectItems[index].value) || 0;
                        const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                        projectPercentages[index].value = transmutedGrade;
                    });

                    calculateProjectTotal();
                }

                function calculateProjectTotal() {
                    let projectTotal = 0;
                    projectInputs.forEach(input => {
                        projectTotal = (projectTotal + (Number(input.value) || 0)) / projectInputs.length;
                    });
                    projectTotalInput.value = projectTotal;

                    // Calculate total percentage for projects
                    let totalProjectPercentage = 0;
                    projectPercentages.forEach(item => {
                        totalProjectPercentage += Number(item.value) || 0;
                    });

                    projectTotalPercentageInput.value = totalProjectPercentage;
                }

                projectInputs.forEach(input => {
                    input.addEventListener('input', updateProjectCalculations);
                });

                projectItems.forEach(input => {
                    input.addEventListener('input', updateProjectCalculations);
                });
            });

        // Handle project calculations for each row
        document.querySelectorAll('tr').forEach(row => {
            const projectInputs = row.querySelectorAll('.project-input');
            const projectPercentages = row.querySelectorAll('.project-percentage');
            const projectTotalInput = row.querySelector('.project-total');
            const projectTotalPercentageInput = row.querySelector('.project-total-percentage');

            // Skip if not a student row (no project inputs)
            if (!projectInputs.length) return;

            function updateProjectCalculations() {
                // Calculate for projects
                projectInputs.forEach((input, index) => {
                    const score = Number(input.value) || 0;
                    const totalItems = Number(projectItems[index].value) || 0;
                    const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                    projectPercentages[index].value = transmutedGrade;
                });

                calculateProjectTotal();
            }

            function calculateProjectTotal() {
                let projectTotal = 0;
                projectInputs.forEach(input => {
                    projectTotal = (projectTotal + (Number(input.value) || 0)) / projectInputs.length;
                });
                projectTotalInput.value = projectTotal;

                // Calculate total percentage for projects
                let totalProjectPercentage = 0;
                projectPercentages.forEach(item => {
                    totalProjectPercentage += Number(item.value) || 0;
                });

                projectTotalPercentageInput.value = totalProjectPercentage;
            }

            projectInputs.forEach(input => {
                input.addEventListener('input', updateProjectCalculations);
            });

            projectItems.forEach(input => {
                input.addEventListener('input', updateProjectCalculations);
            });
          });

        // Handle midterm calculations for each row
        document.querySelectorAll('tr').forEach(row => {
            const termInputs = row.querySelectorAll('.term-exam-input');
            const termPercentages = row.querySelectorAll('.term-exam-percentage');
            const termTotalInput = row.querySelector('.term-exam-total');
            const termTotalPercentageInput = row.querySelector('.term-exam-total-percentage');

            // Skip if not a student row (no term exam inputs)
            if (!termInputs.length) return;

            function updateTermCalculations() {
                // Calculate for term exams
                termInputs.forEach((input, index) => {
                    const score = Number(input.value) || 0;
                    const totalItems = Number(termItems[index].value) || 0;
                    const transmutedGrade = calculatePercentageAndTransmutation(score, totalItems);
                    termPercentages[index].value = transmutedGrade;
                });

                calculateTermTotal();
            }

            function calculateTermTotal() {
                let termTotal = 0;
                termInputs.forEach(input => {
                    termTotal = (termTotal + (Number(input.value) || 0)) / termInputs.length;
                });
                termTotalInput.value = termTotal;

                // Calculate total percentage for term exams
                let totalTermPercentage = 0;
                termPercentages.forEach(item => {
                    totalTermPercentage += Number(item.value) || 0;
                });

                termTotalPercentageInput.value = totalTermPercentage;
            }

            termInputs.forEach(input => {
                input.addEventListener('input', updateTermCalculations);
            });

            termItems.forEach(input => {
                input.addEventListener('input', updateTermCalculations);
            });
        });

        });
    </script>
@endsection
