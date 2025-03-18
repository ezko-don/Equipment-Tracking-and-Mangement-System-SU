@extends('layouts.admin')

@section('content')
    <h1>Manage Equipment</h1>
    <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">Add Equipment</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipment as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <a href="{{ route('admin.equipment.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.equipment.delete', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @if($item->status == 'booked')
                            <form action="{{ route('admin.equipment.approve', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.equipment.return', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Mark as Returned</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection