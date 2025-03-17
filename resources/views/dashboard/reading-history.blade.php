@extends('layouts.app')

@section('title', 'Reading History')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Reading History</h1>
        
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
                                <a href="{{ route('dashboard.reading-history') }}" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-medium">
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
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Reading Statistics</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $readingSessions->count() }}</div>
                                <div class="text-sm text-gray-600">Books Read</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">
                                    {{ $totalPagesRead ?? 0 }}
                                </div>
                                <div class="text-sm text-gray-600">Total Pages Read</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">
                                    {{ $readingSessions->count() > 0 ? round($totalReadingTime / 60) . ' hrs' : '0 hrs' }}
                                </div>
                                <div class="text-sm text-gray-600">Total Reading Time</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900">Reading History</h2>
                            
                            <div class="flex space-x-2">
                                <select id="sort-options" class="form-input rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="recent">Most Recent</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="progress">Progress</option>
                                </select>
                            </div>
                        </div>
                        
                        @if($readingSessions->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-gray-600 mb-4">You haven't read any books yet.</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">Find Books to Read</a>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($readingSessions as $session)
                                    <div class="border rounded-lg overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow">
                                        <div class="md:flex">
                                            <div class="md:w-1/4 p-4 flex justify-center">
                                                <div class="relative">
                                                    @if($session->book->cover_image)
                                                        <img src="{{ Storage::url($session->book->cover_image) }}" alt="{{ $session->book->title }}" class="h-48 object-contain">
                                                    @else
                                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="md:w-3/4 p-4">
                                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $session->book->title }}</h3>
                                                <p class="text-gray-600 mb-3">by {{ $session->book->author->name }}</p>
                                                
                                                <div class="mb-4">
                                                    <div class="flex justify-between text-sm text-gray-700 mb-1">
                                                        <span>Progress: {{ $session->getReadingProgress() }}%</span>
                                                        <span>Page {{ $session->current_page }} of {{ $session->book->pages }}</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $session->getReadingProgress() }}%"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-wrap justify-between items-center">
                                                    <div class="text-sm text-gray-600">
                                                        <span>Last read {{ $session->last_read_at->diffForHumans() }}</span>
                                                    </div>
                                                    
                                                    <div class="flex space-x-2 mt-2 sm:mt-0">
                                                        <a href="{{ route('books.show', $session->book->slug) }}" class="btn btn-secondary text-sm">Book Details</a>
                                                        <a href="{{ route('books.read', $session->book->slug) }}" class="btn btn-primary text-sm">Continue Reading</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                {{ $readingSessions->links() }}
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
        const sortOptions = document.getElementById('sort-options');
        
        if (sortOptions) {
            sortOptions.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                window.location.href = url.toString();
            });
            
            // Set selected option based on URL params
            const urlParams = new URLSearchParams(window.location.search);
            const sortParam = urlParams.get('sort');
            if (sortParam) {
                sortOptions.value = sortParam;
            }
        }
    });
</script>
@endpush