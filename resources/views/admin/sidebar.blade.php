<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            @if (empty(auth()->user()->user_type))
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
                </a>
                
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type) || auth()->user()->user_type === 'Registrar')
                <a class="nav-link {{ request()->routeIs('admin.rates.index') ? 'active' : '' }}"
                    href="{{ route('admin.rates.index') }}">
                    <i class="fas fa-percentage"></i> {{ __('Manage Grading Rates') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type))
                <a class="nav-link {{ request()->routeIs('admin.instructors.index') ? 'active' : '' }}"
                    href="{{ route('admin.instructors.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i> {{ __('Manage Instructor') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type))
                <a class="nav-link {{ request()->routeIs('admin.subjects.index') ? 'active' : '' }}"
                    href="{{ route('admin.subjects.index') }}">
                    <i class="fas fa-book"></i> {{ __('Manage Subjects') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type) || auth()->user()->user_type === 'DOI')
                <a class="nav-link {{ request()->routeIs('admin.requirements.index') ? 'active' : '' }}"
                    href="{{ route('admin.requirements.index') }}">
                    <i class="fas fa-tasks"></i> {{ __('Manage Requirements') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type) || auth()->user()->user_type === 'MIS')
                <a class="nav-link {{ request()->routeIs('admin.classes.index') ? 'active' : '' }}"
                    href="{{ route('admin.classes.index') }}">
                    <i class="fas fa-chalkboard"></i> {{ __('Manage Classes') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type) || auth()->user()->user_type === 'Registrar' || auth()->user()->user_type === 'Chairman')
                <a class="nav-link {{ request()->routeIs('admin.submitted_requirements.index') ? 'active' : '' }}"
                    href="{{ route('admin.submitted_requirements.index') }}">
                    <i class="fas fa-file-alt"></i> {{ __('Manage Submitted Requirements') }}
                </a>
            @endif
        </li>
        <li class="nav-item">
            @if (empty(auth()->user()->user_type))
                <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i> {{ __('Manage Users') }}
                </a>
            @endif
        </li>
        <!-- Add more sidebar items here -->
    </ul>
</div>

<style>
    .sidebar {
        background-color: #f8f9fa;
        color: #343a40;
        padding: 15px;
        height: 100vh;
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
        background-color: #007bff;
        border-radius: 5px;
    }

    .nav-link:hover {
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
    }
</style>
