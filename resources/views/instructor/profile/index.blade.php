@extends('instructor.layout')

@section('instructor-content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4 style="margin-top: 20px; margin-bottom:20px; font-size:40px; text-align:center; font-weight:bolder">
                    My Profile
                </h4>
                <hr style="margin-bottom:20px; border: 1px solid black;"> <!-- Added line here -->
                <div class="card-body" style="border: 1px solid #ddd; border-radius: 5px; padding: 20px;">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('instructor.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Full Name:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="full_name"
                                    value="{{ $instructor->full_name }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email" value="{{ $instructor->email }}"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Position:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="position"
                                    value="{{ $instructor->position }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Department:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="department"
                                    value="{{ $instructor->department }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Username:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="username"
                                    value="{{ $instructor->username }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Current Password:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="current_password">
                                <small class="text-muted">Leave blank if you don't want to change the password</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>New Password:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 text-md-end">
                                <strong>Confirm New Password:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
