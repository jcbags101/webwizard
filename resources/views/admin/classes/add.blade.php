@extends('admin.layout')

@section('admin-content')
    <div class="card">
        <div class="card-header">{{ __('Add Class') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf

                <div class="form-group">
                    <label for="section">{{ __('Section') }}</label>
                    <input id="section" type="text" class="form-control @error('section') is-invalid @enderror"
                        name="section" value="{{ old('section') }}" required autofocus>
                    @error('section')
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
                                {{ $subject->name }}</option>
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
                    <button type="submit" class="btn btn-primary">
                        {{ __('Add Class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
