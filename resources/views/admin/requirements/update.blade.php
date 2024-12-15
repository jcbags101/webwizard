@extends('admin.layout')

@section('admin-content')

    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Update Requirement</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">

        <div class="card-body">
            <form action="{{ route('admin.requirements.update', $requirement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ $requirement->name }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{ $requirement->description }}" required>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deadline">{{ __('Deadline') }}</label>
                    <input id="deadline" type="datetime-local" class="form-control @error('deadline') is-invalid @enderror"
                        name="deadline" value="{{ $requirement->deadline }}">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                        {{ __('Update Requirement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
