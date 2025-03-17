@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Dashboard</h1>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard.profile') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('borrows.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Borrow a Book
                </a>
            </div>
        </div>
        
        <!-- User Welcome -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="md:flex p-6">
                <div class="md:w-3/4 text-white">
                    <h2 class="text-2xl font-bold mb-2">Welcome back, {{ $user->name }}!</h2>
                    <p class="mb-4 text-blue-100">Here's your library activity overview.</p>
                    
                    @if($activeLoans->isEmpty())
                        <div class="mb-4">
                            <span class="text-sm bg-blue-800 text-white px-2 py-1 rounded-full">{{ $activeLoans->count() }} Active Borrows</span>
                            
                            @if($user->hasUnpaidPenalties())
                                <span class="text-sm bg-red-600 text-white px-2 py-1 rounded-full ml-2">Unpaid Penalties</span>
                            @endif
                            
                           
                        </div>
                    @endif
                    
                    <div>
                        <a href="{{ route('books.index') }}" class="inline-block bg-white text-blue-600 font-medium px-4 py-2 rounded-md hover:bg-blue-50 transition-colors text-sm">
                            Explore Books
                        </a>
                    </div>
                </div>
                <div class="md:w-1/4 flex justify-center mt-6 md:mt-0">
                    @if($user->profile_picture)
                        <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" class="h-32 w-32 rounded-full object-cover border-4 border-white">
                    @else
                        <div class="h-32 w-32 rounded-full bg-blue-100 flex items-center justify-center border-4 border-white">
                            <span class="text-5xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Total Books Borrowed</div>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('dashboard.borrow-history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View History →</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Active Borrows</div>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('borrows.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Manage Borrows →</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Unpaid Penalties</div>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('penalties.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Penalties →</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Books Read</div>
                            <div class="text-3xl font-bold text-gray-900">{{ $recentReads->count() }}</div>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('dashboard.reading-history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Reading History →</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Active Loans -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Active Loans</h2>
                    <a href="{{ route('borrows.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                </div>
                
                @if($activeLoans->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-gray-600 mb-4">You don't have any active loans.</p>
                        <a href="{{ route('borrows.create') }}" class="btn btn-primary">Borrow a Book</a>
                    </div>
                @else
                    <!-- Your existing code for displaying activeLoans -->
                    @foreach($activeLoans as $borrow)
                        <!-- Your existing borrow display code -->
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- Unpaid Penalties -->
        @if($unpaidPenalties->isNotEmpty())
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Unpaid Penalties</h2>
                        <a href="{{ route('penalties.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                    </div>
                    
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    You have <span class="font-bold">{{ $unpaidFines->count() }}</span> unpaid penalties totaling <span class="font-bold">Rp {{ number_format($unpaidFines->sum('amount'), 0, ',', '.') }}</span>. Please settle them to continue borrowing books.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Late</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($unpaidFines as $fine)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($fine->bookBorrow->book->cover_image)
                                                        <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($fine->bookBorrow->book->cover_image) }}" alt="{{ $fine->bookBorrow->book->title }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('books.show', $fine->bookBorrow->book->slug) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $fine->bookBorrow->book->title }}</a>
                                                    <div class="text-sm text-gray-500">Returned on {{ $fine->bookBorrow->return_date ? $fine->bookBorrow->return_date->format('M d, Y') : 'Not yet' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $fine->days_late }} days
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                            Rp {{ number_format($fine->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('penalties.index') }}" class="text-blue-600 hover:text-blue-900">Pay Now</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Recent Reading Activity -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Recent Reading Activity</h2>
                    <a href="{{ route('dashboard.reading-history') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
                </div>
                
                @if($readingSessions->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-gray-600 mb-4">You haven't read any books yet.</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">Find Books to Read</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($readingSessions as $session)
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-12 h-16 bg-gray-200 rounded overflow-hidden mr-4">
                                        @if($session->book->cover_image)
                                            <img src="{{ Storage::url($session->book->cover_image) }}" alt="{{ $session->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $session->book->title }}</h4>
                                        <p class="text-sm text-gray-600">Page {{ $session->current_page }}/{{ $session->book->pages }}</p>
                                        <div class="mt-1 flex items-center text-xs text-gray-500">
                                            <span>Last read: {{ $session->last_read_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('books.read', $session->book->slug) }}" class="btn btn-sm btn-primary">Continue</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection