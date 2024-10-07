@extends('admin.layout')

@section('admin-content')
    <div class="card">
        <div class="card-header">{{ __('Add Instructor') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.instructors.store') }}">
                @csrf

                <div class="form-group">
                    <label for="full_name">{{ __('Full Name') }}</label>
                    <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                        name="full_name" value="{{ old('full_name') }}" required autofocus>
                    @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="position">{{ __('Position') }}</label>
                    <input id="position" type="text" class="form-control @error('position') is-invalid @enderror"
                        name="position" value="{{ old('position') }}" required>
                    @error('position')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department">{{ __('Department') }}</label>
                    <select id="department" class="form-control @error('department') is-invalid @enderror" name="department" required>
                        <option value="">{{ __('Select Department') }}</option>
                        <option value="Education" {{ old('department') == 'Education' ? 'selected' : '' }}>{{ __('Education') }}</option>
                        <option value="Technology" {{ old('department') == 'Technology' ? 'selected' : '' }}>{{ __('Technology') }}</option>
                    </select>
                    @error('department')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">{{ __('Username') }}</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Add Instructor') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
