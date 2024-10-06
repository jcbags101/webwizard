@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Submitted Requirements</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requirement</th>
                    <th>File</th>
                    <th>Class</th>
                    <th>Status</th>
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
                        <td>
                            <form action="{{ route('admin.submitted_requirements.update', $submittedRequirement->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending" {{ $submittedRequirement->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $submittedRequirement->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $submittedRequirement->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.submitted_requirements.destroy', $submittedRequirement->id) }}"
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
