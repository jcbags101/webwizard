@extends('admin.layout')

@section('admin-content')
    <div class="container">
        <h1>All Rates</h1>
        <div class="text-end">
            <a href="{{ route('admin.rates.create') }}" class="btn btn-success mb-3">Create Rate</a>
        </div>
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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $rate->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $rate->id }}">
                                    <li><a class="dropdown-item" href="{{ route('admin.rates.edit', $rate->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('admin.rates.destroy', $rate->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
