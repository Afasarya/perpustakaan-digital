@extends('layouts.app')

@section('title', 'Browse Books')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Browse Books</h1>
            
            <div class="w-full md:w-auto">
                <form action="{{ route('books.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="form-input rounded-md shadow-sm px-4 py-2 flex-grow">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Filters Sidebar -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
                    
                    <form action="{{ route('books.index') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-2">Categories</h3>
                            <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="radio" id="category-{{ $category->id }}" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500">
                                        <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">{{ $category->name }} <span class="text-gray-400">({{ $category->books_count }})</span></label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-2">Authors</h3>
                            <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                                @foreach($authors as $author)
                                    <div class="flex items-center">
                                        <input type="radio" id="author-{{ $author->id }}" name="author" value="{{ $author->slug }}" {{ request('author') == $author->slug ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500">
                                        <label for="author-{{ $author->id }}" class="ml-2 text-sm text-gray-700">{{ $author->name }} <span class="text-gray-400">({{ $author->books_count }})</span></label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-2">Sort By</h3>
                            <select name="sort" class="form-input w-full">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                        
                        <div class="flex justify-between">
                            <button type="submit" class="btn btn-primary w-full">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Mobile Filters -->
            <div class="lg:hidden mb-6" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center bg-white rounded-md shadow px-4 py-3 text-gray-700">
                    <span class="font-medium">Filters</span>
                    <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" x-transition class="mt-2 bg-white rounded-lg shadow-md p-4" style="display: none;">
                    <form action="{{ route('books.index') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-900 mb-2">Categories</h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($categories->take(10) as $category)
                                    <div class="flex items-center">
                                        <input type="radio" id="m-category-{{ $category->id }}" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500">
                                        <label for="m-category-{{ $category->id }}" class="ml-2 text-sm text-gray-700">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-900 mb-2">Sort By</h3>
                            <select name="sort" class="form-input w-full">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                        
                        <div class="flex justify-between">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('books.index') }}" class="btn btn-secondary">Clear Filters</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Books Grid -->
            <div class="lg:col-span-3 space-y-6">
                @if($books->isEmpty())
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-700 mb-2">No Books Found</h2>
                        <p class="text-gray-600 mb-4">We couldn't find any books matching your criteria.</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">Clear Filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($books as $book)
                            <div class="card transition-transform duration-300 hover:-translate-y-2">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <div class="relative h-64">
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
                    
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection