@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1>All Submitted Requirements</h1>
        <form action="{{ route('class-records.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div>
              <label>Select Excel/CSV File:</label>
              <input type="file" name="file" required>
          </div>
          <button type="submit">Upload and Import</button>
        </form>

        @if(session('success'))
          <p>{{ session('success') }}</p>
        @endif
    </div>
@endsection
