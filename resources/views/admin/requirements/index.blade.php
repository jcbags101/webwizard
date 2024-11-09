@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Requirements</h1>
        <div class="text-end">
            <a href="{{ route('admin.requirements.create') }}" class="btn btn-success mb-3">Create Requirement</a>
        </div>
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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $requirement->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $requirement->id }}">
                                    <li><a class="dropdown-item" href="{{ route('admin.requirements.edit', $requirement->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('admin.requirements.destroy', $requirement->id) }}" method="POST">
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
    </div>
@endsection
