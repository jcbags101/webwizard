<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}"
                href="{{ route('instructor.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.classes.index') ? 'active' : '' }}"
                href="{{ route('instructor.classes.index') }}">
                <i class="fas fa-chalkboard-teacher"></i> {{ __('Class') }}
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.class_records.index') ? 'active' : '' }}"
                href="{{ route('instructor.class_records.index') }}">
                <i class="fas fa-book"></i> {{ __('Class Record') }}
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.requirements.index') ? 'active' : '' }}"
                href="{{ route('instructor.requirements.index') }}">
                <i class="fas fa-tasks"></i> {{ __('Manage Requirements') }}
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.grades.index') ? 'active' : '' }}"
                href="{{ route('instructor.grades.index') }}">
                <i class="fas fa-graduation-cap"></i> {{ __('Grades') }}
            </a>
        </li> --}}
        <!-- Add more sidebar items here -->
    </ul>
</div>

<style>
    .sidebar {
        background-color: rgba(255, 255, 255, 0.8);
        color: #343a40;
        padding: 15px;
        height: auto;
    }

    .sidebar-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .nav-link {
        color: black;
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
</style>
