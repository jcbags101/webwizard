   @extends('admin.layout')

   @section('admin-content')
       <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary mb-3">Back</a>
       <div class="card">
           <div class="card-header">{{ __('Add Instructor') }}</div>

           <div class="card-body">
               <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
                   @csrf
                   @method('PUT')
                   <div class="form-group">
                       <label for="full_name">Full Name</label>
                       <input type="text" name="full_name" id="full_name" class="form-control"
                           value="{{ $instructor->full_name }}" required>
                   </div>
                   <div class="form-group">
                       <label for="email">Email</label>
                       <input type="email" name="email" id="email" class="form-control"
                           value="{{ $instructor->email }}" required>
                   </div>
                   <div class="form-group">
                       <label for="position">Position</label>
                       <input type="text" name="position" id="position" class="form-control"
                           value="{{ $instructor->position }}" required>
                   </div>
                   <div class="form-group">
                       <label for="department">Department</label>
                       <input type="text" name="department" id="department" class="form-control"
                           value="{{ $instructor->department }}" required>
                   </div>
                   <div class="form-group">
                       <label for="username">Username</label>
                       <input type="text" name="username" id="username" class="form-control"
                           value="{{ $instructor->username }}" required>
                   </div>
                   <div class="form-group">
                       <label for="password">Password (leave blank to keep current password)</label>
                       <input type="password" name="password" id="password" class="form-control">
                   </div>
                   <div class="form-group">
                       <label for="password_confirmation">Confirm Password</label>
                       <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                   </div>
                   <button type="submit" class="btn btn-primary">Update</button>
               </form>
           </div>
       </div>
   @endsection
