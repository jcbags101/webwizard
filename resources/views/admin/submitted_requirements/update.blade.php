@extends('admin.layout')

@section('admin-content')
    
    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Update Submitted Requirement Status</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">

        <div class="card-body">
            <form action="{{ route('admin.submitted_requirements.update', $submittedRequirement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                        @if(auth()->user()->user_type === 'Chairman')
                            <option value="rejected" {{ $submittedRequirement->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                            
                        @elseif(auth()->user()->user_type === 'DOI')
                            <option value="rejected" {{ $submittedRequirement->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                            <option value="accepted" {{ $submittedRequirement->status == 'accepted' ? 'selected' : '' }}>{{ __('Accepted') }}</option>
                        @else
                            <option value="pending" {{ $submittedRequirement->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="accepted" {{ $submittedRequirement->status == 'accepted' ? 'selected' : '' }}>{{ __('Accepted') }}</option>
                            <option value="rejected" {{ $submittedRequirement->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                          
                        @endif
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="remarks">{{ __('Remarks') }}</label>
                    <textarea id="remarks" class="form-control @error('remarks') is-invalid @enderror" name="remarks" rows="3">{{ old('remarks', $submittedRequirement->remarks) }}</textarea>
                    @error('remarks')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                        {{ __('Update Submitted Requirement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
