@extends('instructor.layout')

@section('instructor-content')
    
    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Submit Requirements</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;"> <!-- Added line here -->

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('instructor.requirements.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="requirement_id">{{ __('Requirement') }}</label>
                    <select id="requirement_id" class="form-control @error('requirement_id') is-invalid @enderror"
                        name="requirement_id" required autofocus>
                        <option value="">{{ __('Select Requirement') }}</option>
                        @foreach ($requirements as $requirement)
                            @php
                                $hasPassedDeadline = \Carbon\Carbon::parse($requirement->deadline)->isPast();
                            @endphp
                            <option value="{{ $requirement->id }}"
                                {{ old('requirement_id') == $requirement->id ? 'selected' : '' }}
                                data-deadline="{{ $requirement->deadline }}"
                                class="{{ $hasPassedDeadline ? 'text-danger' : 'text-success' }}">
                                {{ $requirement->name }}
                                (Deadline: {{ $requirement->deadline }})
                                {!! $hasPassedDeadline ? ' <span>⚠️ PAST DEADLINE</span>' : '' !!}
                            </option>
                        @endforeach
                    </select>
                    @error('requirement_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <small id="deadline-warning" class="text-danger d-none">
                        Warning: The deadline for this requirement has passed.
                    </small>
                </div>

                <div class="form-group" id="message-group" style="display: none;">
                    <label for="message">{{ __('Submission Message') }}</label>
                    <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="3"
                        required>{{ old('message') }}</textarea>
                    <small class="text-muted">Please explain why you're submitting after the deadline.</small>
                    @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">{{ __('File') }}</label>
                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror"
                        name="file" required>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="class_id">{{ __('Class') }}</label>
                    <select id="class_id" class="form-control @error('class_id') is-invalid @enderror" name="class_id"
                        required>
                        <option value="">{{ __('Select Class') }}</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->section ? $class->section->name : 'N/A' }} - {{ $class->subject ? $class->subject->name : 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                        {{ __('Submit Requirement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


<script>
    console.log('Script loaded'); // Debug log
    // Function to check deadline and toggle message
    function checkDeadline() {
        console.log('checkDeadline called'); // Debug log
        const select = document.getElementById('requirement_id');
        const selectedOption = select.options[select.selectedIndex];

        console.log('Selected option:', selectedOption); // Debug log

        if (!selectedOption.value) {
            // If no option selected, hide message
            document.getElementById('deadline-warning').classList.add('d-none');
            document.getElementById('message-group').style.display = 'none';
            document.getElementById('message').removeAttribute('required');
            select.classList.remove('border-danger');
            return;
        }

        const deadline = new Date(selectedOption.dataset.deadline);
        const now = new Date();

        console.log('Deadline:', deadline); // Debug log
        console.log('Now:', now); // Debug log

        const warningElement = document.getElementById('deadline-warning');
        const messageGroup = document.getElementById('message-group');
        const messageInput = document.getElementById('message');

        if (deadline.getTime() < now.getTime()) {
            warningElement.classList.remove('d-none');
            select.classList.add('border-danger');
            messageGroup.style.display = 'block';
            messageInput.setAttribute('required', 'required');
        } else {
            warningElement.classList.add('d-none');
            select.classList.remove('border-danger');
            messageGroup.style.display = 'none';
            messageInput.removeAttribute('required');
        }
    }

    // Check on select change and page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded'); // Debug log
        const requirementSelect = document.getElementById('requirement_id');
        console.log('Requirement Select:', requirementSelect); // Debug log

        // Try both change and input events
        requirementSelect.addEventListener('change', function(e) {
            console.log('Change event triggered'); // Debug log
            checkDeadline();
        });

        requirementSelect.addEventListener('input', function(e) {
            console.log('Input event triggered'); // Debug log
            checkDeadline();
        });

        // Check initial state
        checkDeadline();
    });
</script>

<style>
    #requirement_id option.text-danger {
        color: #dc3545;
        font-weight: bold;
    }

    #requirement_id option.text-success {
        color: #28a745;
    }

    #requirement_id.border-danger {
        border-color: #dc3545;
    }
</style>
