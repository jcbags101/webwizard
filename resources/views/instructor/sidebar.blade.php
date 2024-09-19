<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('instructor.dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('instructor.classes.index') }}">{{ __('Class') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subjects.index') }}">{{ __('Class Record') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('instructor.requirements.index') }}">{{ __('Requirements') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.classes.index') }}">{{ __('Submissions') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.classes.index') }}">{{ __('Grades') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.classes.index') }}">{{ __('Uploaded Files') }}</a>
        </li>
        <!-- Add more sidebar items here -->
    </ul>
</div>
