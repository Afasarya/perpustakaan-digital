@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">About Our Library</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Discover the story behind our digital library and our mission to make knowledge accessible to everyone.
            </p>
        </div>
        
        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
            <div class="md:flex">
                <div class="md:w-1/2 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-700 mb-4">
                        Our mission is to create a comprehensive digital library that makes knowledge accessible to everyone, anywhere, at any time. We believe that access to information is a fundamental right, and we're committed to breaking down barriers to education and learning.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Through our platform, we aim to:
                    </p>
                    <ul class="list-disc pl-5 text-gray-700 space-y-2 mb-4">
                        <li>Provide a diverse collection of books across various genres and topics</li>
                        <li>Create a user-friendly reading experience on all devices</li>
                        <li>Facilitate easy borrowing and returning of books</li>
                        <li>Build a community of readers and knowledge seekers</li>
                    </ul>
                    <p class="text-gray-700">
                        We're constantly expanding our collection and improving our services to better serve our users.
                    </p>
                </div>
                <div class="md:w-1/2 bg-blue-100 flex items-center justify-center p-8">
                    <div class="max-w-md">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Library in Numbers</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-blue-600">10,000+</div>
                                <div class="text-sm text-gray-600">Books Available</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-blue-600">5,000+</div>
                                <div class="text-sm text-gray-600">Active Members</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-blue-600">50+</div>
                                <div class="text-sm text-gray-600">Categories</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-blue-600">24/7</div>
                                <div class="text-sm text-gray-600">Online Access</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our Team -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-gray-200">
                        <!-- Replace with actual image -->
                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                            <svg class="w-24 h-24 text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Jane Doe</h3>
                        <p class="text-blue-600 font-medium mb-3">Library Director</p>
                        <p class="text-gray-700">Jane has over 15 years of experience in library science and digital transformation of traditional libraries.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-gray-200">
                        <!-- Replace with actual image -->
                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                            <svg class="w-24 h-24 text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">John Smith</h3>
                        <p class="text-blue-600 font-medium mb-3">Head Librarian</p>
                        <p class="text-gray-700">John oversees our collection development and ensures our catalog meets the diverse needs of our users.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2">
                    <div class="h-48 bg-gray-200">
                        <!-- Replace with actual image -->
                        <div class="w-full h-full flex items-center justify-center bg-blue-50">
                            <svg class="w-24 h-24 text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Emily Chen</h3>
                        <p class="text-blue-600 font-medium mb-3">Technology Manager</p>
                        <p class="text-gray-700">Emily leads our digital infrastructure and ensures our platform is secure, fast, and user-friendly.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Our History</h2>
                <div class="space-y-6">
                    <div class="flex">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">2015</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">The Beginning</h3>
                            <p class="text-gray-700">Our digital library was founded with a small collection of 500 ebooks and a vision to make reading accessible to everyone.</p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">2018</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Expansion</h3>
                            <p class="text-gray-700">We expanded our collection to over 5,000 books and introduced our online reading system, allowing users to read books directly in their browsers.</p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">2020</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Digital Transformation</h3>
                            <p class="text-gray-700">In response to the global pandemic, we completely reimagined our platform to better serve users remotely, introducing new features like virtual book clubs and improved reading tools.</p>
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">2023</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Today</h3>
                            <p class="text-gray-700">Today, we're proud to serve thousands of readers worldwide with our collection of over 10,000 books across all genres and topics.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Join Us CTA -->
        <div class="bg-blue-600 rounded-lg shadow-md overflow-hidden">
            <div class="p-8 text-center">
                <h2 class="text-2xl font-bold text-white mb-4">Join Our Library Today</h2>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    Become a member of our digital library and get access to thousands of books, personalized recommendations, and a vibrant community of readers.
                </p>
                <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 font-medium px-6 py-3 rounded-md hover:bg-blue-50 transition-colors">
                    Register Now
                </a>
            </div>
        </div>
    </div>
</div>
@endsection