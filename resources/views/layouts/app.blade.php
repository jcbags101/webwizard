<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WebWizard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Place these just before closing </body> tag -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    
    <style>
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
            text-align: left;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
            color: #333;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 14px;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn-primary {
            color: #fff;
            background-color: #F9A602;
            border-color: #F9A602;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }
        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #bd2130;
        }

        .sidebar {
            /* background-color: #f8f9fa; */
            color: #343a40;
            padding: 15px;
            height: 100vh;
            font-size: 15px;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav-link {
            color: #495057;
            margin: 5px 0;
        }

        .nav-link.active {
            color: #fff;
            background-color: #F9A602;
            border-radius: 5px;
        }

        .nav-link:hover {
            color: #fff;
            background-color: #F9A602;
            border-radius: 5px;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .card {
            border: none;
            background-color: white;
        }

        /* Advanced H1 Styles */
        h1 { font-size: 1.2rem; line-height: 1.2; color: #1a1a1a; margin-bottom: 0.5rem; font-family: 'Roboto', sans-serif; text-transform: uppercase; letter-spacing: 0.05rem; text-align: left; }

  
        body {
            min-height: 100vh;
            margin: 0;
        }

        nav {
            background-color: #F9A602;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: 0;
            font-size: 0.75rem;
            padding: 0.25em 0.6em;
        }
        
        .notification-icon-wrapper {
            position: relative;
            display: inline-block;
            padding: 0 10px;
        }

        .notification-item.unread {
            background-color: #e3f2fd !important;
        }

        .notification-item.read {
            background-color: #ffffff !important;
        }
    </style>

    <script>
        function markAsRead(element, notificationId) {
            console.log(notificationId);
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    element.classList.remove('unread');
                    element.classList.add('read');
                    updateNotificationCount();
                }
            });
        }

        function updateNotificationCount() {
            const count = document.querySelectorAll('.notification-item.unread').length;
            document.getElementById('notification-count').textContent = count;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('mark-all-read').addEventListener('click', function(e) {
                e.preventDefault();
                
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelectorAll('.notification-item.unread').forEach(item => {
                            item.classList.remove('unread');
                            item.classList.add('read');
                        });
                        document.getElementById('notification-count').textContent = '0';
                    }
                });
            });
        });
    </script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background-color: #F9A602!important;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/ctu_logo.png') }}" alt="Logo" style="width: 40px; height: 40px;" class="m-2">
                    WebWizard
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'instructor')
                                        <a class="dropdown-item" href="{{ route('instructor.profile') }}">
                                            Profile
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="notificationsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="notification-icon-wrapper">
                                        <i class="fa-solid fa-bell"></i>
                                        <span class="badge bg-danger notification-badge" id="notification-count">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" id="notifications-menu" style="max-height: 300px; overflow-y: auto; min-width: 300px;">
                                    <div class="dropdown-header d-flex justify-content-between align-items-center px-3">
                                        <span>Notifications</span>
                                        <a href="#" class="text-decoration-none" id="mark-all-read">Mark all as read</a>
                                    </div>
                                    <div id="notifications-list">
                                        @forelse(Auth::user()->notifications as $notification)
                                            <a  
                                               href="{{ $notification->data['link'] ?? '#' }}"
                                               class="dropdown-item notification-item {{ $notification->read_at ? 'read' : 'unread' }} p-3 border-bottom" 
                                               data-notification-id="{{ $notification->id }}"
                                               onclick="markAsRead(this, '{{ $notification->id }}')">
                                                <small class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</small>
                                                <div>{{ $notification->data['message'] }}</div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-center">No notifications</div>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 mx-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
