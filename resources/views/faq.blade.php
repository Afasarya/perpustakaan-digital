@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-lg text-gray-600">
                Find answers to common questions about our library services.
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden" x-data="{active: null}">
            <div class="divide-y divide-gray-200">
                <!-- Question 1 -->
                <div class="p-6">
                    <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I borrow a book?</h3>
                        <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>To borrow a book, follow these steps:</p>
                        <ol class="list-decimal pl-5 mt-2 space-y-2">
                            <li>Sign in to your account (or create one if you haven't already)</li>
                            <li>Browse our collection and find the book you want to borrow</li>
                            <li>On the book's page, click the "Borrow" button</li>
                            <li>You can then visit the library to pick up your book or read it online if it's available in digital format</li>
                        </ol>
                        <p class="mt-2">Note that you must not have any unpaid late fees to borrow books.</p>
                    </div>
                </div>
                
                <!-- Question 2 -->
                <div class="p-6">
                    <button @click="active !== 2 ? active = 2 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How long can I keep borrowed books?</h3>
                        <svg :class="{'rotate-180': active === 2}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>The standard loan period for books is 7 days. If you need more time, and no one else has reserved the book, you may be able to extend your borrowing period. You can manage your loans and request extensions from your dashboard.</p>
                    </div>
                </div>
                
                <!-- Question 3 -->
                <div class="p-6">
                    <button @click="active !== 3 ? active = 3 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">What happens if I return a book late?</h3>
                        <svg :class="{'rotate-180': active === 3}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>If you return a book after its due date, you will be charged a late fee of Rp 1,000 per day. These fees will need to be paid before you can borrow any more books.</p>
                        <p class="mt-2">You can pay your late fees online or at the library. We accept cash, credit/debit cards, and digital payment methods.</p>
                    </div>
                </div>
                
                <!-- Question 4 -->
                <div class="p-6">
                    <button @click="active !== 4 ? active = 4 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">Can I read books online?</h3>
                        <svg :class="{'rotate-180': active === 4}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 4" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>Yes, many of our books are available in digital format. If a book has a digital version, you'll see a "Read Online" button on its page. You can read digital books directly in your browser without needing to download any additional software.</p>
                        <p class="mt-2">Your reading progress is saved automatically, so you can continue from where you left off on any device.</p>
                    </div>
                </div>
                
                <!-- Question 5 -->
                <div class="p-6">
                    <button @click="active !== 5 ? active = 5 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">How do I pay late fees?</h3>
                        <svg :class="{'rotate-180': active === 5}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 5" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>You can pay your late fees through several methods:</p>
                        <ul class="list-disc pl-5 mt-2 space-y-2">
                            <li>Online payment through your dashboard</li>
                            <li>Payment at the library's circulation desk</li>
                            <li>Bank transfer to our account (details provided in your account)</li>
                        </ul>
                        <p class="mt-2">After making a payment, please upload the payment receipt in your account or bring it to the library for verification.</p>
                    </div>
                </div>
                
                <!-- Question 6 -->
                <div class="p-6">
                    <button @click="active !== 6 ? active = 6 : active = null" class="flex justify-between items-center w-full text-left">
                        <h3 class="text-lg font-medium text-gray-900">Can I request a book that isn't in the library?</h3>
                        <svg :class="{'rotate-180': active === 6}" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 6" class="mt-4 text-gray-600" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
                        <p>Yes, we welcome book requests from our members. If there's a specific book you'd like to see in our collection, please contact our librarian through the Contact page or speak with a library staff member.</p>
                        <p class="mt-2">We'll consider all requests and add books based on availability and demand.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-12 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Still Have Questions?</h2>
            <p class="text-lg text-gray-600 mb-6">
                If you couldn't find the answer to your question, feel free to reach out to us.
            </p>
            <a href="{{ route('contact') }}" class="btn btn-primary inline-block">Contact Us</a>
        </div>
    </div>
</div>
@endsection