@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
    </div>

    <h1>Activity Logs</h1>
    @if ($activityLogs->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Submitted Requirement</th>
                    <th>Instructor</th>
                    <th>Action</th>
                    <th>Changes</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activityLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->submittedRequirement->requirement->name ?? 'Requirement deleted' }}</td>
                        <td>{{ $log->submittedRequirement->instructor->full_name ?? 'Requirement deleted' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->changes ?? 'No changes' }}</td>
                        <td>{{ $log->created_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            No activity logs found for this submitted requirement.
        </div>
    @endif
@endsection
