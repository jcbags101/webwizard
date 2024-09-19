@extends('admin.layout')

@section('admin-content')
    <div class="card">
        <div class="card-header text-center text-bold h1">{{ __('Admin Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="text-center">
                <img src="{{ asset('images/ctu_logo.png') }}" alt="CTU Logo">
            </div>
        </div>
    </div>
@endsection
