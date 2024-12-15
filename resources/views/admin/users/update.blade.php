   @extends('admin.layout')

   @section('admin-content')
      
       <div class="card">
       <h1 style="margin-top: 20px; font-size:25px">Update User Account</h1>
       <hr style="margin-bottom:20px; border: 0.5px solid black;">

           <div class="card-body">
               <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                   @csrf
                   @method('PUT')
                   <div class="form-group">
                       <label for="name">Name</label>
                       <input type="text" name="name" id="name" class="form-control"
                           value="{{ $user->name }}" required>
                   </div>
                   <div class="form-group">
                       <label for="email">Email</label>
                       <input type="email" name="email" id="email" class="form-control"
                           value="{{ $user->email }}" required>
                   </div>
                   <div class="form-group">
                       <label for="user_type">User Type</label>
                       <select name="user_type" id="user_type" class="form-control" required>
                           <option value="MIS" {{ $user->user_type == 'MIS' ? 'selected' : '' }}>MIS</option>
                           <option value="Chairman" {{ $user->user_type == 'Chairman' ? 'selected' : '' }}>Chairman</option>
                           <option value="Registrar" {{ $user->user_type == 'Registrar' ? 'selected' : '' }}>Registrar</option>
                           <option value="DOI" {{ $user->user_type == 'DOI' ? 'selected' : '' }}>DOI</option>

                       </select>
                   </div>
                   <div class="form-group">
                       <label for="password">Password (leave blank to keep current password)</label>
                       <input type="password" name="password" id="password" class="form-control">
                   </div>
                   <div class="form-group">
                       <label for="password_confirmation">Confirm Password</label>
                       <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                   </div>
                   <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update</button>
               </form>
           </div>
       </div>
   @endsection
