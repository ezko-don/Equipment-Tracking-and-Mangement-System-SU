@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
 <!-- Extra Navigation Bar -->
    <nav class="w-full bg-blue-600 p-3 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-white text-lg font-bold">Home</a>
            <div>
                <a href="{{ route('login') }}" class="w-full bg-blue-400 text-gray-500 font-bold py-3 mt-6 rounded-lg hover:bg-blue-600 transition duration-200">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-3 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Sign Up
                </a>
            </div>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm mt-8">
        <!-- Institution Logo -->
        <div class="flex justify-center">
            <img src="{{ asset('image.png') }}" alt="Institution Logo" class="h-12">
        </div>

        <h2 class="text-xl font-bold text-center text-gray-800 mt-3">Create an Account</h2>
        <p class="text-center text-gray-600 text-sm">Join our equipment tracking system</p>

        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf
            <div>
                <label for="name" class="block text-gray-800 font-semibold">Full Name</label>
                <input id="name" type="text" name="name" required autofocus
              class="w-full p-3 mt-2 border border-gray-400 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
            </div>

            <div class="mt-3">
                <label for="email" class="block text-gray-800 font-semibold">Email Address</label>
                <input id="email" type="email" name="email" required
                    class="w-full p-3 mt-2 border border-gray-400 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
            </div>

            <div class="mt-3">
                <label for="password" class="block text-gray-800 font-semibold">Password</label>
                <input id="password" type="password" name="password" required
                class="w-full p-3 mt-2 border border-gray-400 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
            </div>

            <div class="mt-3">
                <label for="password-confirm" class="block text-gray-800 font-semibold">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                class="w-full p-3 mt-2 border border-gray-400 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
            </div>

            <button type="submit"
            class="w-full bg-blue-400 text-gray-500 font-bold py-3 mt-6 rounded-lg hover:bg-blue-600 transition duration-200">
            Sign Up
        </button>
        

            <p class="text-center text-gray-700 text-sm mt-3">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
