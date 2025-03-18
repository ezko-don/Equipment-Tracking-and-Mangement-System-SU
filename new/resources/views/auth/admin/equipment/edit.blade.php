@extends('layouts.admin')

@section('content')
    <h1>Edit Equipment</h1>
    <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" value="{{ $equipment->name }}" required>
        <input type="text" name="category" value="{{ $equipment->category }}" required>
        <textarea name="description">{{ $equipment->description }}</textarea>
        <select name="status">
            <option value="available" {{ $equipment->status == 'available' ? 'selected' : '' }}>Available</option>
            <option value="booked" {{ $equipment->status == 'booked' ? 'selected' : '' }}>Booked</option>
        </select>
        <input type="file" name="image">
        <button type="submit">Update Equipment</button>
    </form>
@endsection
