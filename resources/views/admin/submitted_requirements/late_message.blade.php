@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

        <div class="card">
            <div class="card-body">
                <p><strong>Date:</strong> {{ $submittedRequirement->created_at->format('F d, Y') }}</p>

                <p class="text-uppercase mb-0">MARIA CHRISTINA A. FLORES, LPT, MSME</p>
                <p>Chairman, College of Technology</p>

                <p class="mt-4">Dear Ms. Flores,</p>

                <div class="mt-4 mb-4">web
                    {{ $submittedRequirement->message }}
                </div>

                <p class="mb-0">{{ $submittedRequirement->instructor->full_name }}</p>
                <p>Instructor</p>
            </div>
        </div>
    </div>
@endsection
