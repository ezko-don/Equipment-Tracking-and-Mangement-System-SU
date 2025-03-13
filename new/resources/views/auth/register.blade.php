@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Create an Account</h2>
        <p class="text-center text-gray-500">Join our equipment tracking system</p>

        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf
            <div>
                <label for="name" class="block text-gray-600">Full Name</label>
                <input id="name" type="text" name="name" required autofocus
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mt-4">
                <label for="email" class="block text-gray-600">Email Address</label>
                <input id="email" type="email" name="email" required
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mt-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mt-4">
                <label for="password-confirm" class="block text-gray-600">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-3 mt-6 rounded-lg hover:bg-blue-600 transition duration-200">
                Sign Up
            </button>

            <p class="text-center text-gray-600 mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection