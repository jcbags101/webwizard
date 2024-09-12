@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Requirements</h1>
        <a href="{{ route('admin.requirements.create') }}" class="btn btn-success mb-3">Create Requirement</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requirements as $requirement)
                    <tr>
                        <td>{{ $requirement->id }}</td>
                        <td>{{ $requirement->name }}</td>
                        <td>{{ $requirement->description }}</td>
                        <td>
                            <a href="{{ route('admin.requirements.edit', $requirement->id) }}"
                                class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.requirements.destroy', $requirement->id) }}" method="POST"
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
