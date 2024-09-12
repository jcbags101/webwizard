<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.instructors.index') }}">{{ __('Manage Instructor') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subjects.index') }}">{{ __('Manage Subjects') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.requirements.index') }}">{{ __('Manage Requirements') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.classes.index') }}">{{ __('Manage Classes') }}</a>
        </li>
        <!-- Add more sidebar items here -->
    </ul>
</div>
