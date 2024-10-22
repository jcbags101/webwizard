@extends('admin.layout')

@section('admin-content')
    <div class="card">
        <div class="card-header">{{ __('Add User') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_type">{{ __('User Type') }}</label>
                    <select id="user_type" class="form-control @error('user_type') is-invalid @enderror" name="user_type" required>
                        <option value="">{{ __('Select User Type') }}</option>
                        <option value="MIS" {{ old('user_type') == 'MIS' ? 'selected' : '' }}>{{ __('MIS') }}</option>
                        <option value="Chairman" {{ old('user_type') == 'Chairman' ? 'selected' : '' }}>{{ __('Chairman') }}</option>
                        <option value="Registrar" {{ old('user_type') == 'Registrar' ? 'selected' : '' }}>{{ __('Registrar DOI') }}</option>
                        <option value="DOI" {{ old('user_type') == 'DOI' ? 'selected' : '' }}>{{ __('DOI') }}</option>
                    </select>
                    @error('user_type')
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
                        {{ __('Add User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
