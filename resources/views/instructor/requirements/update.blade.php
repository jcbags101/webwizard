@extends('instructor.layout')

@section('instructor-content')
    <a href="{{ route('instructor.requirements.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Update Submitted Requirement') }}</div>

        <div class="card-body">
            <form action="{{ route('instructor.requirements.update', $submittedRequirement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="file">{{ __('File') }}</label>
                    <div class="custom-file">
                        <input id="file" type="file" class="custom-file-input @error('file') is-invalid @enderror"
                            name="file" required>
                        <label class="custom-file-label" for="file">{{ $submittedRequirement->file ? basename($submittedRequirement->file) : __('Choose file') }}</label>
                    </div>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                        <option value="pending" {{ $submittedRequirement->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $submittedRequirement->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $submittedRequirement->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="remarks">{{ __('Remarks') }}</label>
                    <textarea id="remarks" class="form-control @error('remarks') is-invalid @enderror" name="remarks">{{ $submittedRequirement->remarks }}</textarea>
                    @error('remarks')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Submitted Requirement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
