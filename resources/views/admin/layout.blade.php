@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('admin.sidebar')
            </div>
            <div class="col-md-10">
                @yield('admin-content')
            </div>
        </div>
    </div>
@endsection
