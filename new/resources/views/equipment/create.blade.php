@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Add New Equipment</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('equipment.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name Input -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" required
                class="w-full p-3 border border-gray-500 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-500"
                placeholder="Enter equipment name">
        </div>

        <!-- Category Input -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Category</label>
            <input type="text" name="category" required
                class="w-full p-3 border border-gray-500 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-500"
                placeholder="Enter category">
        </div>

        <!-- Description Input -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Description</label>
            <textarea name="description"
                class="w-full p-3 border border-gray-500 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none placeholder-gray-500"
                placeholder="Enter description"></textarea>
        </div>

        <!-- Status Dropdown -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Status</label>
            <select name="status"
                class="w-full p-3 border border-gray-500 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="available">Available</option>
                <option value="booked">Booked</option>
            </select>
        </div>

        <!-- Image Upload -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Upload Image</label>
            <input type="file" name="image" id="imageInput" accept="image/*"
                class="w-full p-3 border border-gray-500 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Image Path Display -->
        <div class="mb-4">
            <p class="text-gray-700 font-medium">Selected File:</p>
            <p id="imagePath" class="text-gray-500 italic">No file selected</p>
        </div>

        <!-- Image Preview -->
        <div class="mb-4">
            <p class="text-gray-700 font-medium">Image Preview:</p>
            <img id="imagePreview" src="#" alt="Preview" class="hidden w-full h-40 object-cover rounded-md mt-2">
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition duration-200">
            Submit
        </button>
    </form>
</div>

<!-- JavaScript for Image Preview & File Name -->
<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            // Show file name
            document.getElementById('imagePath').textContent = file.name;

            // Show image preview
            let reader = new FileReader();
            reader.onload = function() {
                let image = document.getElementById('imagePreview');
                image.src = reader.result;
                image.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePath').textContent = "No file selected";
        }
    });
</script>
@endsection