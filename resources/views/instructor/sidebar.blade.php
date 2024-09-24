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
</div>
