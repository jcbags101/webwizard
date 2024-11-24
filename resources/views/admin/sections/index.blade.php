@extends('admin.layout')

@section('admin-content')
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
                        <th>Semester</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->school_year }}</td>
                            <td>{{ $section->semester }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $section->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $section->id }}">
                                        <li><a class="dropdown-item" href="{{ route('admin.sections.edit', $section->id) }}">Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.sections.showStudents', $section->id) }}">View Students</a></li>
                                        <li>
                                            <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
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
@endsection
