@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <!-- Login form fields -->
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
    </div>
</form>
@endsection