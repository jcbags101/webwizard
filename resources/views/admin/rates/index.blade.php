@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Rates</h1>
        <a href="{{ route('admin.rates.create') }}" class="btn btn-success mb-3">Create Rate</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rates as $rate)
                    <tr>
                        <td>{{ $rate->id }}</td>
                        <td>{{ $rate->name }}</td>
                        <td>{{ $rate->rate }}</td>
                        <td>
                            <a href="{{ route('admin.rates.edit', $rate->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.rates.destroy', $rate->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
