@extends('instructor.layout')

@section('instructor-content')
    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Update Submitted Requirement</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">
        <div class="card-body">
            <form action="{{ route('instructor.requirements.update', $submittedRequirement->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="requirement_id">{{ __('Requirement') }}</label>
                    <select id="requirement_id" class="form-control @error('requirement_id') is-invalid @enderror"
                        name="requirement_id" required>
                        <option value="">{{ __('Select Requirement') }}</option>
                        @foreach ($requirements as $requirement)
                            <option value="{{ $requirement->id }}"
                                {{ $submittedRequirement->requirement_id == $requirement->id ? 'selected' : '' }}>
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
                    <div class="custom-file">
                        <input id="file" type="file" class="custom-file-input @error('file') is-invalid @enderror"
                            name="file">
                        <label class="custom-file-label"
                            for="file">{{ $submittedRequirement->file ? basename($submittedRequirement->file) : __('Choose file') }}</label>
                    </div>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="class_id">{{ __('Class') }}</label>
                    <select id="class_id" class="form-control @error('class_id') is-invalid @enderror" name="class_id" required>
                        <option value="">{{ __('Select Class') }}</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ $submittedRequirement->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->section ? $class->section->name : 'N/A' }} - {{ $class->subject ? $class->subject->name : 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group mt-3">
                    @if ($submittedRequirement->edit_status === 'approved')
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                            {{ __('Update Submitted Requirement') }}
                        </button>
                    @endif
                    @if ($submittedRequirement->edit_status !== 'approved')
                        <small class="text-muted d-block mt-2">
                            {{ __('You can only update this requirement after your edit request has been approved.') }}
                        </small>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
