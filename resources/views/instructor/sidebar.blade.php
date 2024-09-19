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
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.subjects.index') ? 'active' : '' }}"
                href="{{ route('admin.subjects.index') }}">
                <i class="fas fa-book"></i> {{ __('Class Record') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('instructor.requirements.index') ? 'active' : '' }}"
                href="{{ route('instructor.requirements.index') }}">
                <i class="fas fa-tasks"></i> {{ __('Requirements') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.classes.index') ? 'active' : '' }}"
                href="{{ route('admin.classes.index') }}">
                <i class="fas fa-file-alt"></i> {{ __('Submissions') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.classes.index') ? 'active' : '' }}"
                href="{{ route('admin.classes.index') }}">
                <i class="fas fa-graduation-cap"></i> {{ __('Grades') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.classes.index') ? 'active' : '' }}"
                href="{{ route('admin.classes.index') }}">
                <i class="fas fa-upload"></i> {{ __('Uploaded Files') }}
            </a>
        </li>
        <!-- Add more sidebar items here -->
    </ul>
    <div class="sidebar-footer">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>
    </div>
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
