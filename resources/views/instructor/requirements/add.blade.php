@extends('instructor.layout')

@section('instructor-content')
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Add Submitted Requirement') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('instructor.requirements.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="requirement_id">{{ __('Requirement') }}</label>
                    <select id="requirement_id" class="form-control @error('requirement_id') is-invalid @enderror"
                        name="requirement_id" required autofocus>
                        <option value="">{{ __('Select Requirement') }}</option>
                        @foreach ($requirements as $requirement)
                            <option value="{{ $requirement->id }}"
                                {{ old('requirement_id') == $requirement->id ? 'selected' : '' }}>
                                {{ $requirement->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('requirement_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">{{ __('File') }}</label>
                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror"
                        name="file" required>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="class_id">{{ __('Class') }}</label>
                    <select id="class_id" class="form-control @error('class_id') is-invalid @enderror" name="class_id"
                        required>
                        <option value="">{{ __('Select Class') }}</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->section ? $class->section->name : 'N/A' }} - {{ $class->subject ? $class->subject->name : 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit Requirement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
