@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-sm">
        <h2 class="text-3xl font-semibold text-center text-white mb-6">Create an Account</h2>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <!-- Name -->
            <div>
                <label for="name" class="text-white block">Full Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 mt-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="text-white block">Email Address</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 mt-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="text-white block">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 mt-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="text-white block">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 mt-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>

            <!-- Register Button -->
            <div>
                <button type="submit" class="w-full py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:bg-opacity-90 transition duration-300">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-gray-400">
            <p>Already have an account? <a href="{{ route('login.index') }}" class="text-movie-accent hover:underline">Login</a></p>
        </div>
    </div>
</div>
@endsection
