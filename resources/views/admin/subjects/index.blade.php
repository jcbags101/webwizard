@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Subjects</h1>
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-success mb-3">Create Subject</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Units</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->units }}</td>
                        <td>
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
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
    </div>
@endsection
