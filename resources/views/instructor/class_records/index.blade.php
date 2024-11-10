@extends('instructor.layout')

@section('instructor-content')
    <div class="container">
        <h1 class="mb-4">All Submitted Requirements</h1>

        <div class="card">
            <div class="card-header">Import Records</div>
            <div class="card-body">
                <form action="{{ route('class-records.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Import Records from Excel/CSV</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" required
                                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-upload"></i> Upload and Import
                            </button>
                        </div>
                        <small class="form-text text-muted">Supported formats: .xlsx, .xls, .csv</small>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
