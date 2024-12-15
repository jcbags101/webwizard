@extends('instructor.layout')

@section('instructor-content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4 style="margin-top: 20px; margin-bottom:20px; font-size:40px; text-align:center; font-weight:bolder">
                    My Profile
                </h4>
                <hr style="margin-bottom:20px; border: 1px solid black;">
                <div class="card-body" style="border: 1px solid #ddd; border-radius: 5px; padding: 20px;">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-md-4 text-md-end">
                                <strong>Profile Image:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control" id="profileImageInput" name="profile_image"
                                    accept="image/*">
                                <small class="text-muted">Leave blank if you don't want to change the image</small>
                                <div id="imagePreview" style="margin-top: 10px; display: none;">
                                    <img id="preview" src="" alt="Image Preview"
                                        style="max-width: 100%; border: 1px solid #ddd; border-radius: 5px;">
                                </div>
                                @if ($instructor->profile_image)
                                    <div style="margin-top: 10px;">
                                        <strong>Current Image:</strong>
                                        <img src="{{ asset('storage/' . $instructor->profile_image) }}"
                                            alt="Current Profile Image"
                                            style="max-width: 100%; border: 1px solid #ddd; border-radius: 5px;">
                                    </div>
                                @endif
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        const imageInput = document.getElementById('profileImageInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('preview');
        const cropContainer = document.getElementById('cropContainer');
        const cropPreview = document.getElementById('cropPreview');
        let cropper;

        imageInput.addEventListener('change', function(event) {
            const files = event.target.files;
            const done = (url) => {
                previewImage.src = url;
                imagePreview.style.display = 'block';
            };
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    done(e.target.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
    </script>
@endsection
