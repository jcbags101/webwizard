@extends('admin.layout')

@section('admin-content')
    
    <div class="card">
    <h1 style="margin-top: 20px; font-size:25px">Update Subject</h1>
    <hr style="margin-bottom:20px; border: 0.5px solid black;">

        <div class="card-body">
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ $subject->name }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{ $subject->description }}" required>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="code">{{ __('Code') }}</label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                        name="code" value="{{ $subject->code }}" required>
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="units">{{ __('Units') }}</label>
                    <input id="units" type="number" class="form-control @error('units') is-invalid @enderror"
                        name="units" value="{{ $subject->units }}" required>
                    @error('units')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                        {{ __('Update Subject') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
