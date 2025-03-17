@extends('layouts.app')

@section('title', $book->title . ' - Reading')

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Reading Header -->
        <div class="bg-white rounded-lg shadow-md mb-4 p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 mb-1">{{ $book->title }}</h1>
                    <p class="text-sm text-gray-600">by {{ $book->author->name }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('books.show', $book->slug) }}" class="btn btn-secondary btn-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Book Details
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Simple PDF Viewer -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden p-0">
            <div id="pdf-viewer-container" class="w-full h-[700px] bg-gray-800">
                <!-- Direct PDF embedding -->
                <embed 
                    src="{{ Storage::url($book->file_path) }}"
                    type="application/pdf"
                    width="100%"
                    height="100%"
                    style="border: none;"
                >
                
                <!-- Fallback if embed doesn't work -->
                <div id="fallback-message" class="hidden absolute top-0 left-0 w-full h-full bg-gray-800 flex items-center justify-center">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md text-center">
                        <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h3 class="text-lg font-bold mb-2">Unable to Display Book</h3>
                        <p class="mb-4">Your browser cannot display this book format directly.</p>
                        <a href="{{ route('books.show', $book->slug) }}" class="btn btn-primary">Return to Book Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple check to see if the PDF loaded
    document.addEventListener('DOMContentLoaded', function() {
        const embedElement = document.querySelector('embed');
        const fallbackMessage = document.getElementById('fallback-message');
        
        // Check if PDF loaded after a short delay
        setTimeout(function() {
            // Simple test - if embed element has no content or zero height
            if (!embedElement.contentDocument || 
                (embedElement.clientHeight === 0 && window.getComputedStyle(embedElement).height === '0px')) {
                fallbackMessage.classList.remove('hidden');
            }
        }, 2000);
    });
</script>
@endpush