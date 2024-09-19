@extends('admin.layout')

@section('admin-content')
    <a href="{{ route('admin.rates.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Add Rate') }}</div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.rates.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rate">{{ __('Rate') }}</label>
                    <input id="rate" type="number" step="0.01"
                        class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}"
                        required>
                    @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div id="dynamic-fields"></div>

                <div class="form-group mb-0">
                    {{-- <button type="button" class="btn btn-secondary" id="add-field">{{ __('Add More Fields') }}</button> --}}
                    <button type="submit" class="btn btn-primary">
                        {{ __('Add Rate') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-field').addEventListener('click', function() {
            var dynamicFields = document.getElementById('dynamic-fields');
            var newField = document.createElement('div');
            newField.classList.add('form-group');
            newField.innerHTML = `
                <label for="name">{{ __('Name') }}</label>
                <input type="text" class="form-control" name="name[]" required>
                <label for="rate">{{ __('Rate') }}</label>
                <input type="number" step="0.01" class="form-control" name="rate[]" required>
            `;
            dynamicFields.appendChild(newField);
        });
    </script>
@endsection
