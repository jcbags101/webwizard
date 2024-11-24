@extends('admin.layout')

@section('admin-content')
        <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary mb-3">Back</a>
        
        <div class="card">
            <div class="card-header">
                <h4>Students in Section: {{ $section->name }}</h4>
                <h6 class="text-muted">School Year: {{ $section->school_year }}</h6>
            </div>

            <div class="card-body">
                @if($section->students->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student ID/LRN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($section->students as $student)
                                <tr>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.sections.removeStudent', ['sectionId' => $section->id, 'studentId' => $student->id]) }}" 
                                              method="POST" 
                                              style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to remove this student from the section?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        No students found in this section.
                    </div>
                @endif
            </div>
        </div>
@endsection
