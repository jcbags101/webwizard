@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('instructor.sidebar')
            </div>
            <div class="col-md-10">
                @yield('instructor-content')
            </div>
        </div>
    </div>
@endsection