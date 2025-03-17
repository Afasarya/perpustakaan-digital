@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/3 lg:w-1/4 p-6 flex justify-center">
                    <div class="relative">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="max-h-96 object-contain">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="md:w-2/3 lg:w-3/4 p-6">
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-primary-100 text-primary-800">
                            {{ $book->category->name }}
                        </span>
                        <div class="flex items-center text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($book->getAverageRating()))
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                    </svg>
                                @endif
                            @endfor
                            <span class="text-sm text-gray-600 ml-1">{{ number_format($book->getAverageRating(), 1) }} ({{ $book->getRatingsCount() }})</span>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-700 mb-4">by <a href="{{ route('books.index', ['author' => $book->author->slug]) }}" class="text-primary-600 hover:underline">{{ $book->author->name }}</a></p>
                    
                    <div class="mb-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Publisher:</span>
                                <span class="text-gray-900 font-medium">{{ $book->publisher->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">ISBN:</span>
                                <span class="text-gray-900 font-medium">{{ $book->isbn }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Published:</span>
                                <span class="text-gray-900 font-medium">{{ $book->publish_year }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Language:</span>
                                <span class="text-gray-900 font-medium">{{ $book->language }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Pages:</span>
                                <span class="text-gray-900 font-medium">{{ $book->pages ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium {{ $book->isAvailable() ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->isAvailable() ? 'Available' : 'Borrowed' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Description</h3>
                        <p>{{ $book->description ?: 'No description available for this book.' }}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mt-8">
                        @if($book->isAvailable())
                            @auth
                                <a href="{{ route('borrows.create', $book->id) }}" class="btn btn-primary">Borrow This Book</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login to Borrow</a>
                            @endauth
                        @endif
                        
                        @if($book->file_path)
                            @auth
                                <a href="{{ route('books.read', $book->slug) }}" class="btn btn-secondary">Read Online</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary">Login to Read</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Book Reviews -->
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews</h2>
                
                @auth
                    <div class="mb-8 border-b pb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Write a Review</h3>
                        <form action="{{ route('books.store-rating', $book->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Your Rating</label>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="hidden" {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}>
                                        <label for="rating-{{ $i }}" class="cursor-pointer">
                                            <svg class="w-8 h-8 {{ $userRating && $userRating->rating >= $i ? 'text-yellow-500' : 'text-gray-300' }} fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="review" class="block text-gray-700 mb-2">Your Review (Optional)</label>
                                <textarea id="review" name="review" rows="4" class="form-input">{{ $userRating ? $userRating->review : '' }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-4 mb-8 text-center">
                        <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">login</a> to leave a review.</p>
                    </div>
                @endauth
                
                <!-- Existing Reviews -->
                <div>
                    @if($book->ratings->isEmpty())
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <p class="text-gray-600">No reviews yet. Be the first to review this book!</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($book->ratings as $rating)
                                <div class="border-b pb-6 last:border-b-0 last:pb-0">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center text-yellow-500 mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating->rating)
                                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $rating->user->name }}</span>
                                        <span class="text-gray-600 text-sm ml-2">{{ $rating->created_at->format('M d, Y') }}</span>
                                    </div>
                                    @if($rating->review)
                                        <p class="text-gray-700">{{ $rating->review }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Related Books -->
        @if($relatedBooks->isNotEmpty())
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">You might also like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedBooks as $relatedBook)
                        <div class="card transition-transform duration-300 hover:-translate-y-2">
                            <a href="{{ route('books.show', $relatedBook->slug) }}">
                                <div class="relative h-64">
                                    @if($relatedBook->cover_image)
                                        <img src="{{ Storage::url($relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $relatedBook->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-3">by {{ $relatedBook->author->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Rating star selection
        const ratingLabels = document.querySelectorAll('[id^="rating-"]');
        ratingLabels.forEach(label => {
            label.addEventListener('click', function() {
                const rating = this.getAttribute('for').split('-')[1];
                document.querySelectorAll('[id^="rating-"]').forEach((input, index) => {
                    const star = input.nextElementSibling.querySelector('svg');
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-500');
                    } else {
                        star.classList.remove('text-yellow-500');
                        star.classList.add('text-gray-300');
                    }
                });
            });
        });
    });
</script>
@endpush