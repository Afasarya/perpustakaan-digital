@extends('layouts.app')

@section('title', 'Borrow a Book')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Borrow a Book</h1>
            <p class="text-gray-600 mt-2">Please select a book to borrow.</p>
        </div>
        
        @if(auth()->user()->hasUnpaidPenalties())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            You have unpaid penalties. Please settle your penalties before borrowing books.
                        </p>
                        <p class="mt-2">
                            <a href="{{ route('penalties.index') }}" class="text-red-700 font-medium underline">View Penalties</a>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    @if($selectedBook)
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Confirm Book Borrowing</h2>
                            <div class="flex flex-col md:flex-row md:items-center">
                                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                    @if($selectedBook->cover_image)
                                        <img src="{{ Storage::url($selectedBook->cover_image) }}" alt="{{ $selectedBook->title }}" class="h-48 w-32 object-cover rounded-md shadow">
                                    @else
                                        <div class="h-48 w-32 bg-gray-200 flex items-center justify-center rounded-md shadow">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $selectedBook->title }}</h3>
                                    <p class="text-gray-600 mb-2">by {{ $selectedBook->author->name }}</p>
                                    <p class="text-gray-600 mb-2">Category: {{ $selectedBook->category->name }}</p>
                                    <p class="text-gray-600 mb-4">ISBN: {{ $selectedBook->isbn }}</p>
                                    
                                    <form action="{{ route('borrows.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $selectedBook->id }}">
                                        <div class="flex space-x-3">
                                            <button type="submit" class="btn btn-primary">Confirm Borrowing</button>
                                            <a href="{{ route('borrows.create') }}" class="btn btn-secondary">Select Another Book</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Available Books</h2>
                        
                        @if($availableBooks->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-600 mb-4">No books are available for borrowing at the moment.</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">Browse All Books</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach($availableBooks as $book)
                                    <div class="card transition-transform duration-300 hover:-translate-y-2">
                                        <a href="{{ route('borrows.create', $book->id) }}">
                                            <div class="relative h-56">
                                                @if($book->cover_image)
                                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="absolute bottom-0 left-0 bg-primary-600 text-white px-3 py-1 text-sm">
                                                    {{ $book->category->name }}
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $book->title }}</h3>
                                                <p class="text-sm text-gray-600 mb-3">by {{ $book->author->name }}</p>
                                                <div class="flex items-center mt-2">
                                                    <button class="btn btn-primary w-full">Select</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection