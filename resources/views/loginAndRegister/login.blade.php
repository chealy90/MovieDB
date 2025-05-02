@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="bg-gray-800 rounded-xl p-8 shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-white text-center mb-6">Login</h2>

        @if (session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.login') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-white text-sm font-semibold mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="w-full p-3 rounded-full bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-white text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 rounded-full bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="Enter your password" required>
                @error('password')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-between items-center mb-6">
                <label for="remember" class="flex items-center text-white text-sm">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    Remember Me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-cyan-500 text-sm hover:text-cyan-400">Forgot Your Password?</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-full hover:opacity-90 transition-all duration-300">
                Log In
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-white text-sm">Don't have an account? <a href="#" class="text-cyan-500 hover:text-cyan-400">Register</a></p>
        </div>
    </div>
</div>
@endsection
