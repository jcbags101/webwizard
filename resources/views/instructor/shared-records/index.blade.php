@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1>Shared Class Records</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Class Section</th>
                        <th>Shared By</th>
                        <th>Shared Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($sharedClasses->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No shared class records found</td>
                        </tr>
                    @else
                        @foreach($sharedClasses as $sharedClass)
                            <tr>
                                <td>{{ $sharedClass->section->name }}</td>
                                <td>{{ $sharedClass->instructor->full_name }}</td>
                                <td>{{ $sharedClass->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('instructor.shared-records.show', $sharedClass->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
