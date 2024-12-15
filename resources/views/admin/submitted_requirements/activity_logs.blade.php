@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
    </div>

    <h1>Activity Logs for Submitted Requirement ID: {{ $submittedRequirement->id }}</h1>
    @if ($activityLogs->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Action</th>
                    <th>Changes</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activityLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->changes ?? 'No changes' }}</td>
                        <td>{{ $log->created_at->format('M d, Y h:ia') }}</td>
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
