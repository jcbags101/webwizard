@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1>All Submitted Requirements</h1>
        <div class="text-end">
            <a href="{{ route('instructor.requirements.create') }}" class="btn btn-success mb-3">Submit
            Requirement</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requirement</th>
                    <th>File</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Remarks</th>
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
                            @if ($submittedRequirement->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($submittedRequirement->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @elseif ($submittedRequirement->status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $submittedRequirement->remarks ?? 'No remarks' }}</td>
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
