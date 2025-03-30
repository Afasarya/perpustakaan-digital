@extends('layouts.app')

@section('title', 'Welcome to Library App')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    Your Digital <span class="text-primary-600">Library</span> at Your Fingertips
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Explore, borrow, and read books from our vast collection. Enhance your knowledge and enjoy reading from anywhere.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('books.index') }}" class="btn btn-primary text-center px-8 py-3 text-lg">
                        Browse Books
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary text-center px-8 py-3 text-lg">
                        Join Now
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2">
                <img src="{{ asset('images/hero.jpg') }}" alt="Library" class="rounded-lg shadow-xl object-cover h-96 w-full">
            </div>
        </div>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Books</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Discover our handpicked selection of must-read books across various genres and topics.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
            @foreach($featuredBooks as $book)
                <div class="card transition-transform duration-300 hover:-translate-y-2">
                    <a href="{{ route('books.show', $book->slug) }}">
                        <div class="relative h-80">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                            <div class="flex items-center justify-between">
                                <span class="text-primary-600 font-medium">
                                    {{ $book->isAvailable() ? 'Available' : 'Borrowed' }}
                                </span>
                                <div class="flex items-center">
                                    <span class="text-yellow-500 mr-1">★</span>
                                    <span class="text-sm text-gray-700">{{ number_format($book->getAverageRating(), 1) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('books.index') }}" class="btn btn-primary">View All Books</a>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Our library system is designed to make borrowing and reading books as simple as possible.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white rounded-lg shadow-md">
                <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Browse Books</h3>
                <p class="text-gray-600">
                    Explore our extensive collection of books across various categories and find your next great read.
                </p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-lg shadow-md">
                <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Borrow Books</h3>
                <p class="text-gray-600">
                    Choose the books you want to read, borrow them with a few clicks, and pick them up at our library.
                </p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-lg shadow-md">
                <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Return on Time</h3>
                <p class="text-gray-600">
                    Return books by their due date to avoid late fees. We'll send you reminders to help you keep track.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Categories</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Discover books by your favorite genres and categories.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('books.index', ['category' => $category->slug]) }}" class="block bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $category->name }}</h3>
                        <p class="opacity-80 mb-4">{{ Str::limit($category->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">{{ $category->books_count }} Books</span>
                            <span class="text-sm">Explore →</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-12 bg-primary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Ready to Start Reading?</h2>
        <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto">
            Join thousands of readers who have already discovered their next favorite book through our library.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn bg-white text-primary-700 hover:bg-gray-100 px-8 py-3 text-lg">
                Sign Up Now
            </a>
            <a href="{{ route('books.index') }}" class="btn bg-primary-700 text-white hover:bg-primary-800 px-8 py-3 text-lg">
                Browse Books
            </a>
        </div>
    </div>
</section>
@endsection