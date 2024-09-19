@extends('admin.layout')

@section('admin-content')
    <a href="{{ route('admin.rates.index') }}" class="btn btn-secondary mb-3">Back</a>
    <div class="card">
        <div class="card-header">{{ __('Update Rate') }}</div>

        <div class="card-body">
            <form action="{{ route('admin.rates.update', $rate->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ $rate->name }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rate">{{ __('Rate') }}</label>
                    <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror"
                        name="rate" value="{{ $rate->rate }}" required>
                    @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Rate') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
