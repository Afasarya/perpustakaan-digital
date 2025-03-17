@extends('layouts.app')

@section('title', 'Borrowing History')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Borrowing History</h1>
        
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
                                <a href="{{ route('dashboard.change-password') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Change Password
                                </a>
                                <a href="{{ route('dashboard.reading-history') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Reading History
                                </a>
                                <a href="{{ route('dashboard.borrow-history') }}" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-medium">
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
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Borrowing Statistics</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $totalBorrows ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Total Borrows</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $activeBorrows ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Active Borrows</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $overdueBorrows ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Overdue Books</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $returnedOnTime ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Returned On Time</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Borrows -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Active Borrows</h2>
                        
                        @if(($activeLoans ?? collect())->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-600 mb-4">You don't have any active loans at the moment.</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">Borrow a Book</a>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($activeLoans ?? collect() as $borrow)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if($borrow->book->cover_image)
                                                                <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($borrow->book->cover_image) }}" alt="{{ $borrow->book->title }}">
                                                            @else
                                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <a href="{{ route('books.show', $borrow->book->slug) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $borrow->book->title }}</a>
                                                            <div class="text-sm text-gray-500">by {{ $borrow->book->author->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $borrow->borrow_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $borrow->isOverdue() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ $borrow->due_date->format('M d, Y') }}
                                                        @if($borrow->isOverdue())
                                                            <span class="ml-1">(Overdue)</span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $borrow->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($borrow->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        @if($borrow->book->file_path)
                                                            <a href="{{ route('books.read', $borrow->book->slug) }}" class="text-blue-600 hover:text-blue-900">Read</a>
                                                        @endif
                                                        <form action="{{ route('borrows.return', $borrow->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to return this book?');">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900">Return</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Borrowing History -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900">Borrowing History</h2>
                            <div>
                                <select id="status-filter" class="form-input rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">All Status</option>
                                    <option value="returned">Returned</option>
                                    <option value="overdue">Overdue</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div>
                        
                        @if(($history ?? collect())->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-gray-600">No borrowing history found.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($history ?? collect() as $borrow)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if($borrow->book->cover_image)
                                                                <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($borrow->book->cover_image) }}" alt="{{ $borrow->book->title }}">
                                                            @else
                                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <a href="{{ route('books.show', $borrow->book->slug) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $borrow->book->title }}</a>
                                                            <div class="text-sm text-gray-500">by {{ $borrow->book->author->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $borrow->borrow_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                        $borrow->status === 'returned' ? 'bg-green-100 text-green-800' : 
                                                        ($borrow->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') 
                                                    }}">
                                                        {{ ucfirst($borrow->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-6">
                                {{ ($history ?? collect())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const url = new URL(window.location.href);
                
                if (this.value) {
                    url.searchParams.set('status', this.value);
                } else {
                    url.searchParams.delete('status');
                }
                
                window.location.href = url.toString();
            });
            
            // Set selected option based on URL params
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            if (statusParam) {
                statusFilter.value = statusParam;
            }
        }
    });
</script>
@endpush