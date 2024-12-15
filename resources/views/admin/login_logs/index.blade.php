@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>
    </div>

    <h1>Login Activity Logs</h1>
    @if ($loginLogs->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loginLogs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user->name ?? 'N/A' }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>{{ $log->user_agent }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            No login activity logs found.
        </div>
    @endif
@endsection
