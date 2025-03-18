@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-3xl font-bold text-center mb-6">Admin Dashboard</h2>

    <div class="grid grid-cols-3 gap-6 text-white">
        <div class="bg-blue-500 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Total Equipment</h3>
            <p class="text-3xl">{{ $totalEquipment }}</p>
        </div>
        <div class="bg-green-500 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Total Bookings</h3>
            <p class="text-3xl">{{ $totalBookings }}</p>
        </div>
        <div class="bg-red-500 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Total Admins</h3>
            <p class="text-3xl">{{ $totalAdmins }}</p>
        </div>
    </div>

    <div class="mt-10 flex space-x-4">
        <a href="{{ route('admin.bookings') }}" class="px-6 py-3 bg-green-500 text-white rounded-md">Manage Bookings</a>
        <a href="{{ route('admin.equipment.index') }}" class="px-6 py-3 bg-blue-500 text-white rounded-md">Manage Equipment</a>
        <a href="{{ route('admin.manage') }}" class="px-6 py-3 bg-red-500 text-white rounded-md">Manage Admins</a>
    </div>
</div>
@endsection