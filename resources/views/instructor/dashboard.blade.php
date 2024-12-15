@extends('instructor.layout')

@section('instructor-content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            align-items: center;
        }

        img {
            max-width: 300px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        img:hover {
            transform: scale(1.05);
        }
        p {
            font-size: 25px;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        .alert {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 600px;
            font-size: 16px;
            text-align: center;
            border-radius: 5px;
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center">
        <img src="{{ asset('images/ctu_logo.png') }}" alt="CTU Logo">
        <hr style="margin-bottom: 20px; border: 0.5px solid black; width: 75%; margin-left: auto; margin-right: auto;">

        <p>
            Welcome to <span style="color:orange">WebWizard</span>, {{ ucfirst(Auth::user()->role) }}! <br>Easily manage your classes, requirements, and records in one place.
        </p>
    </div>
@endsection
