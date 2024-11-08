@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Sections</h1>
        <div class="text-end">
            <a href="{{ route('admin.sections.create') }}" class="btn btn-success mb-3">Create Section</a>
        </div>
        @if($sections->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>School Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->school_year }}</td>
                            <td>
                                <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('admin.sections.showStudents', $section->id) }}" class="btn btn-info">View Students</a>
                                <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                No sections found.
            </div>
        @endif
    </div>
@endsection
