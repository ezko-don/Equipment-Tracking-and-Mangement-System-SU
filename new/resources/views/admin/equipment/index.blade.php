@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Manage Equipment</h1>
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Equipment
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="equipmentTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Booked By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" style="max-width: 50px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status === 'available' ? 'success' : ($item->status === 'booked' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                @if($item->user)
                                    {{ $item->user->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.equipment.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($item->status === 'booked')
                                        <form action="{{ route('admin.equipment.return', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to mark this as returned?')">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.equipment.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this equipment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#equipmentTable').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 10,
            "language": {
                "search": "Search Equipment:",
                "lengthMenu": "Show _MENU_ equipment per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ equipment",
                "infoEmpty": "No equipment found",
                "infoFiltered": "(filtered from _MAX_ total equipment)"
            }
        });
    });
</script>
@endpush
@endsection 