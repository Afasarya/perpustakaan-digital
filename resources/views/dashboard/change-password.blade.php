@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Change Password</h1>
        
        <div class="md:flex md:gap-8">
            <!-- Sidebar -->
            <div class="md:w-1/4 mb-6 md:mb-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="text-center mb-4">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-32 h-32 rounded-full mx-auto object-cover">
                            @else
                                <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center mx-auto">
                                    <span class="text-4xl font-bold text-blue-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h2 class="text-xl font-bold text-gray-900 mt-4">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div class="border-t pt-4">
                            <nav class="space-y-2">
                                <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Dashboard
                                </a>
                                <a href="{{ route('dashboard.profile') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Profile
                                </a>
                                <a href="{{ route('dashboard.change-password') }}" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-medium">
                                    Change Password
                                </a>
                                <a href="{{ route('dashboard.reading-history') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Reading History
                                </a>
                                <a href="{{ route('dashboard.borrow-history') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Borrowing History
                                </a>
                                <a href="{{ route('dashboard.penalty-history') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Penalty History
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="md:w-3/4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Change Your Password</h2>
                        
                        @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <form action="{{ route('dashboard.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" id="password" name="password" required class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Password Security Tips</h2>
                        
                        <div class="space-y-4 text-gray-700">
                            <div class="flex">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-600 mt-0.5">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p><span class="font-medium">Use a strong password</span> - At least 8 characters, including uppercase, lowercase, numbers, and special characters.</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-600 mt-0.5">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p><span class="font-medium">Don't reuse passwords</span> - Use different passwords for different accounts.</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-600 mt-0.5">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p><span class="font-medium">Change regularly</span> - Update your password every 3-6 months for better security.</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-600 mt-0.5">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p><span class="font-medium">Avoid personal information</span> - Don't use names, birthdays, or other easily guessable information.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection