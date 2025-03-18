@extends('layouts.app')

@section('content')
<!-- Ensure Bootstrap CSS is loaded -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mx-auto mt-10">
    <h2 class="text-3xl font-bold text-center mb-6">Equipment List</h2>

    <!-- Filter Section -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('equipment.index') }}" class="px-4 py-2 bg-gray-300 rounded-md mx-2">All</a>
        <a href="{{ route('equipment.index', ['status' => 'available']) }}" class="px-4 py-2 bg-green-500 text-white rounded-md mx-2">Available</a>
        <a href="{{ route('equipment.index', ['status' => 'booked']) }}" class="px-4 py-2 bg-red-500 text-white rounded-md mx-2">Booked</a>
    </div>

    <!-- Check if equipment is empty -->
    @if($equipment->isEmpty())
        <p class="text-center text-gray-500 mt-6">No equipment found.</p>
    @else
        <!-- Equipment Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($equipment as $item)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('default-placeholder.jpg') }}" 
                      alt="{{ $item->name }}" 
                     class="w-7 h-7 object-cover rounded-md">
                  
                     <div class="bg-gray-200 p-4 rounded-md shadow-md">
                        <h3 class="text-gray-800 font-medium">{{ $item->name }}</h3>
                        <p class="text-gray-800 font-medium">{{ $item->category }}</p>
                        <p class="mt-2">
                            <span class="px-2 py-1 rounded-md text-red-500 font-bold text-sm 
                                {{ $item->status == 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </p>

                        <!-- Show Book Button only for available equipment -->
                        @if ($item->status == 'available')
                            <button 
                                type="button"
                                class="bg-blue-500 text-gray-800 font-bold px-4 py-2 rounded-md mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#bookingModal"
                                data-equipment-id="{{ $item->id }}"
                                data-equipment-name="{{ $item->name }}"
                                data-equipment-image="{{ isset($item->image) ? asset('storage/' . $item->image) : asset('default-image.jpg') }}"
                                data-user-name="{{ Auth::check() ? Auth::user()->name : 'Guest' }}">
                                Book Me
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel" style="color: blue;">Book Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" method="POST" action="{{ route('equipment.book') }}">
                    @csrf
                    <input type="hidden" name="equipment_id" id="equipmentId">
                    
                    <div class="text-center">
                        <img id="equipmentImage" src="" class="img-fluid rounded mb-3" style="max-width: 100px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="equipmentName" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gray-800 font-bold">User Name</label>
                        @if(Auth::check())
                            <input type="text" class="form-control" id="userName" value="{{ Auth::user()->name }}" readonly>
                        @else
                            <input type="text" class="form-control" id="userName" value="Guest" readonly>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gray-800 font-bold" >Event Name</label>
                        <input type="text" name="event_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gray-800 font-bold" >Location</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-gray-800 font-bold">Booking Date & Time</label>
                        <input type="text" class="form-control" id="currentDateTime" readonly>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ensure Bootstrap JS is loaded -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var bookingModal = document.getElementById('bookingModal');

    // Ensure the modal is properly triggered
    bookingModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        document.getElementById('equipmentId').value = button.getAttribute('data-equipment-id');
        document.getElementById('equipmentName').value = button.getAttribute('data-equipment-name');
        document.getElementById('equipmentImage').src = button.getAttribute('data-equipment-image');
        document.getElementById('userName').value = button.getAttribute('data-user-name');

        var now = new Date();
        var formattedDateTime = now.toLocaleString();
        document.getElementById('currentDateTime').value = formattedDateTime;
    });
});
</script>

@endsection