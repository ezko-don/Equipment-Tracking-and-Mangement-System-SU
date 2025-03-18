@extends('layouts.admin')

@section('content')
    <h1>Add Equipment</h1>
    <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Equipment Name" required>
        <input type="text" name="category" placeholder="Category" required>
        <textarea name="description" placeholder="Description"></textarea>
        <select name="status">
            <option value="available">Available</option>
            <option value="booked">Booked</option>
        </select>
        <input type="file" name="image">
        <button type="submit">Add Equipment</button>
    </form>
@endsection
