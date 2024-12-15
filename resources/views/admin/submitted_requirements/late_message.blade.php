@extends('admin.layout')

@section('admin-content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <p><strong>{{ $submittedRequirement->created_at->format('F d, Y') }}</strong></p>

                <p class="text-uppercase mb-0"><strong>MARIA CHRISTINA A. FLORES, LPT, MSME</strong></p>
                <p>Chairman, College of Technology</p>

                <p class="mt-4">Dear Ms. Flores,</p>

                <div class="mt-4 mb-4">web
                    {{ $submittedRequirement->message }}
                </div>

                <p class="mb-0"><strong>{{ $submittedRequirement->instructor->full_name }}</strong></p>
                <p>Instructor</p>
            </div>
        </div>
    </div>
@endsection
