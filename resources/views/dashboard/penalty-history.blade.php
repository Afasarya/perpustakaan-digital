@extends('layouts.app')

@section('title', 'Penalty History')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Penalty History</h1>
        
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
                                <a href="{{ route('dashboard.borrow-history') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                    Borrowing History
                                </a>
                                <a href="{{ route('dashboard.penalty-history') }}" class="block px-4 py-2 rounded-md bg-blue-50 text-blue-700 font-medium">
                                    Penalty History
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="md:w-3/4">
                <!-- Penalty Summary -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Penalty Summary</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">{{ $totalPenalties ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Total Penalties</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-1">Rp {{ number_format($totalPaidAmount ?? 0, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-600">Total Paid</div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-3xl font-bold {{ ($totalUnpaidAmount ?? 0) > 0 ? 'text-red-600' : 'text-green-600' }} mb-1">
                                    Rp {{ number_format($totalUnpaidAmount ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-600">Unpaid Amount</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Unpaid Penalties -->
                @if(($unpaidPenalties ?? collect())->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Unpaid Penalties</h2>
                            
                            <!-- Warning Message -->
                            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">
                                            You have <span class="font-bold">{{ ($unpaidPenalties ?? collect())->count() }}</span> unpaid penalties totaling <span class="font-bold">Rp {{ number_format(($unpaidPenalties ?? collect())->sum('amount'), 0, ',', '.') }}</span>. Please settle them to continue borrowing books.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @foreach($unpaidPenalties ?? collect() as $penalty)
                                    <div class="border rounded-lg overflow-hidden bg-white shadow-sm">
                                        <div class="p-4">
                                            <div class="md:flex md:justify-between md:items-center">
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900">{{ $penalty->bookBorrow->book->title }}</h3>
                                                    <div class="mt-1 text-sm text-gray-600">
                                                        <p>Borrowed on: {{ $penalty->bookBorrow->borrow_date->format('M d, Y') }}</p>
                                                        <p>Returned on: {{ $penalty->bookBorrow->return_date ? $penalty->bookBorrow->return_date->format('M d, Y') : 'Not returned yet' }}</p>
                                                        <p class="text-red-600 font-medium mt-1">{{ $penalty->days_late }} days late - Penalty: Rp {{ number_format($penalty->amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-4 md:mt-0">
                                                    <button type="button" onclick="document.getElementById('payment-modal-{{ $penalty->id }}').classList.remove('hidden')" class="btn btn-primary w-full md:w-auto">
                                                        Pay Now
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Payment Modal -->
                                    <div id="payment-modal-{{ $penalty->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                                        <div class="bg-white rounded-lg max-w-lg w-full overflow-hidden">
                                            <div class="p-6">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-lg font-bold text-gray-900">Payment Details</h3>
                                                    <button type="button" onclick="document.getElementById('payment-modal-{{ $penalty->id }}').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <div class="mb-6">
                                                    <div class="bg-gray-50 rounded-md p-4 mb-4">
                                                        <div class="flex justify-between mb-2">
                                                            <span class="text-gray-600">Penalty ID:</span>
                                                            <span class="font-medium">{{ $penalty->id }}</span>
                                                        </div>
                                                        <div class="flex justify-between mb-2">
                                                            <span class="text-gray-600">Book:</span>
                                                            <span class="font-medium">{{ $penalty->bookBorrow->book->title }}</span>
                                                        </div>
                                                        <div class="flex justify-between mb-2">
                                                            <span class="text-gray-600">Late Days:</span>
                                                            <span class="font-medium">{{ $penalty->days_late }} days</span>
                                                        </div>
                                                        <div class="flex justify-between mb-2">
                                                            <span class="text-gray-600">Amount:</span>
                                                            <span class="font-bold text-red-600">Rp {{ number_format($penalty->amount, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="bg-blue-50 p-4 rounded-md mb-4">
                                                        <h4 class="font-medium text-blue-800 mb-2">Payment Instructions</h4>
                                                        <ol class="list-decimal list-inside text-sm space-y-1 text-gray-700">
                                                            <li>Transfer the exact amount to our bank account: <span class="font-medium">Bank XYZ 1234-5678-9012</span></li>
                                                            <li>Include your penalty ID ({{ $penalty->id }}) as payment reference</li>
                                                            <li>Take a screenshot or photo of your payment receipt</li>
                                                            <li>Upload the receipt below</li>
                                                        </ol>
                                                    </div>
                                                    
                                                    <form action="{{ route('penalties.upload-receipt', $penalty->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="payment_receipt_{{ $penalty->id }}" class="block text-sm font-medium text-gray-700 mb-1">Upload Payment Receipt</label>
                                                            <input type="file" id="payment_receipt_{{ $penalty->id }}" name="payment_receipt" accept="image/*" required class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                            <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, GIF. Max size: 2MB</p>
                                                        </div>
                                                        
                                                        <div class="flex justify-end space-x-2">
                                                            <button type="button" onclick="document.getElementById('payment-modal-{{ $penalty->id }}').classList.add('hidden')" class="btn btn-secondary">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                Submit Payment
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Paid Penalties -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Payment History</h2>
                        
                        @if(($paidPenalties ?? collect())->isEmpty())
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-600">No payment history found.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($paidPenalties ?? collect() as $penalty)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if($penalty->bookBorrow->book->cover_image)
                                                                <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($penalty->bookBorrow->book->cover_image) }}" alt="{{ $penalty->bookBorrow->book->title }}">
                                                            @else
                                                                <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <a href="{{ route('books.show', $penalty->bookBorrow->book->slug) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $penalty->bookBorrow->book->title }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    Rp {{ number_format($penalty->amount, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $penalty->days_late }} days late
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $penalty->paid_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if($penalty->payment_receipt)
                                                        <a href="{{ Storage::url($penalty->payment_receipt) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View Receipt</a>
                                                    @else
                                                        <span class="text-gray-500">No receipt</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-6">
                                {{ ($paidPenalties ?? collect())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection