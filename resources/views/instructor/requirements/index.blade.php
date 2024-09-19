@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1>All Submitted Requirements</h1>
        <a href="{{ route('instructor.requirements.create') }}" class="btn btn-success mb-3">Submit
            Requirement</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requirement</th>
                    <th>File</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requirements as $submittedRequirement)
                    <tr>
                        <td>{{ $submittedRequirement->id }}</td>
                        <td>{{ $submittedRequirement->requirement->name }}</td>
                        <td><a href="{{ asset('storage/' . $submittedRequirement->file) }}" target="_blank">View File</a></td>
                        <td>{{ $submittedRequirement->class->section }}</td>
                        <td>
                            <a href="{{ route('instructor.requirements.edit', $submittedRequirement->id) }}"
                                class="btn btn-primary">Edit</a>
                            <form action="{{ route('instructor.requirements.destroy', $submittedRequirement->id) }}"
                                method="POST" style="display:inline-block;">
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
