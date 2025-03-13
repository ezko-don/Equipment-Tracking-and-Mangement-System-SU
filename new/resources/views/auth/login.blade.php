@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Welcome Back</h2>
        <p class="text-center text-gray-500">Login to access your account</p>

        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-600">Email Address</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mt-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mt-4 flex justify-between items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox text-blue-500">
                    <span class="ml-2 text-gray-600">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Forgot password?</a>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-3 mt-6 rounded-lg hover:bg-blue-600 transition duration-200">
                Login
            </button>

            <p class="text-center text-gray-600 mt-4">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign up</a>
            </p>
        </form>
    </div>
</div>
@endsection