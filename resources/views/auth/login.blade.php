@extends('layouts.app')

@section('title', 'Login - ETS Web')

@section('body-class', 'min-h-screen bg-gradient-to-br from-blue-500 via-purple-600 to-purple-700 flex items-center justify-center px-4')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
    <div class="text-center mb-8">
        <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mb-4">
            <i data-feather="shield" class="h-8 w-8 text-white"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Login</h1>
        <p class="text-gray-600">Masuk ke sistem ETS Web</p>
    </div>
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <ul class="list-none">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700 text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-gray-700">
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" 
                   id="remember" 
                   name="remember" 
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
        </div>
        
        <button type="submit" 
                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-4 rounded-lg hover:from-blue-600 hover:to-purple-700 focus:ring-4 focus:ring-blue-200 transition duration-200 font-medium transform hover:-translate-y-0.5">
            Masuk
        </button>
    </form>
</div>
@endsection