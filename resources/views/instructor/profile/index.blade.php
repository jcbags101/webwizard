@extends('instructor.layout')

@section('instructor-content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Instructor Profile</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
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
                                    <input type="text" class="form-control" name="full_name" value="{{ $instructor->full_name }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 text-md-end">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" value="{{ $instructor->email }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 text-md-end">
                                    <strong>Position:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="position" value="{{ $instructor->position }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 text-md-end">
                                    <strong>Department:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="department" value="{{ $instructor->department }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 text-md-end">
                                    <strong>Username:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="username" value="{{ $instructor->username }}" required>
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

