@extends('admin.layout')

@section('admin-content')

    <div class="card">
        
    <h1 style="margin-top: 20px; font-size:25px">Create Class</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf

                <div class="form-group">
                    <label for="section_id">{{ __('Section') }}</label>
                    <select id="section_id" class="form-control @error('section_id') is-invalid @enderror" name="section_id" required>
                        <option value="">{{ __('Select Section') }}</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->school_year }})
                            </option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="schedule">{{ __('Schedule') }}</label>
                    <input id="schedule" type="text" class="form-control @error('schedule') is-invalid @enderror"
                        name="schedule" value="{{ old('schedule') }}" required>
                    @error('schedule')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject_id">{{ __('Subject') }}</label>
                    <select id="subject_id" class="form-control @error('subject_id') is-invalid @enderror" name="subject_id"
                        required>
                        <!-- Assuming you will populate this with subjects from the database -->
                        <option value="">{{ __('Select Subject') }}</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }} - {{ $subject->description }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="instructor_id">{{ __('Instructor') }}</label>
                    <select id="instructor_id" class="form-control @error('instructor_id') is-invalid @enderror"
                        name="instructor_id" required>
                        <!-- Assuming you will populate this with instructors from the database -->
                        <option value="">{{ __('Select Instructor') }}</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('instructor_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top:10px">
                        {{ __('Add Class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
