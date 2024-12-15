@extends('admin.layout')

@section('admin-content')
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
        hr {
            margin-bottom: 20px;
            border: 0.5px solid black;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
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
        <hr>
        <p>
            Welcome to <span style="color:orange">WebWizard</span>, {{ Auth::user()->name }}! <br>
            @if (auth()->user()->user_type === 'Chairman')
                Manage departmental responsibilities efficiently and oversee all operations with ease.
            @elseif (auth()->user()->user_type === 'DOI')
                Oversee and guide instructional development for seamless learning experiences.
            @elseif (auth()->user()->user_type === 'MIS')
                Handle and streamline information systems for effective administrative management.
            @elseif (auth()->user()->user_type === 'Registrar')
                Manage student records and ensure accurate documentation for institutional compliance.
            @else
                Administer the system effectively and provide support to other users.
            @endif
        </p>
    </div>
@endsection
