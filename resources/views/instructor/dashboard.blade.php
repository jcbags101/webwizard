@extends('instructor.layout')

@section('instructor-content')
    <div class="card">
        <div class="card-header">{{ __('Instructor Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in! ambot') }}
        </div>
    </div>
@endsection
