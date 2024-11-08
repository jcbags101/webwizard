@extends('admin.layout')

@section('admin-content')
    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Update Class') }}</div>

        <div class="card-body">
            <form action="{{ route('admin.classes.update', $schoolClass->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="section">{{ __('Section') }}</label>
                    <select id="section_id" class="form-control @error('section_id') is-invalid @enderror" name="section_id" required>
                        <option value="">{{ __('Select Section') }}</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ $schoolClass->section_id == $section->id ? 'selected' : '' }}>
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
                        name="schedule" value="{{ $schoolClass->schedule }}" required>
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
                        <option value="">{{ __('Select Subject') }}</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ $schoolClass->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
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
                        <option value="">{{ __('Select Instructor') }}</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ $schoolClass->instructor_id == $instructor->id ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
