@extends('layouts.app')

@section('title', 'My Penalties')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">My Penalties</h1>
        
        <!-- Unpaid Penalties -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Unpaid Penalties</h2>
                
                @if($unpaidPenalties->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600">You don't have any unpaid penalties. Great job!</p>
                    </div>
                @else
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    You have unpaid penalties totaling <span class="font-bold">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</span>. Please settle them to continue borrowing books.
                                </p>
                            </div>
                        </div>
                    </div>
                
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Late</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($unpaidPenalties as $penalty)
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
                                                    <div class="text-sm font-medium text-gray-900">{{ $penalty->bookBorrow->book->title }}</div>
                                                    <div class="text-sm text-gray-500">Borrowed on {{ $penalty->bookBorrow->borrow_date->format('M d, Y') }}</div>
                                                    <div class="text-sm text-gray-500">Returned on {{ $penalty->bookBorrow->return_date ? $penalty->bookBorrow->return_date->format('M d, Y') : 'Not returned yet' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $penalty->days_late }} days
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            Rp {{ number_format($penalty->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-primary-600 hover:text-primary-900" onclick="document.getElementById('upload-modal-{{ $penalty->id }}').classList.remove('hidden')">
                                                Upload Payment
                                            </button>
                                            
                                            <!-- Upload Modal -->
                                            <div id="upload-modal-{{ $penalty->id }}" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
                                                <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-medium text-gray-900">Upload Payment Receipt</h3>
                                                        <button onclick="document.getElementById('upload-modal-{{ $penalty->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <form action="{{ route('penalties.upload-receipt', $penalty->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <p class="text-sm text-gray-600 mb-2">Penalty Amount: <span class="font-medium">Rp {{ number_format($penalty->amount, 0, ',', '.') }}</span></p>
                                                            <p class="text-sm text-gray-600 mb-4">Please upload a screenshot or image of your payment receipt.</p>
                                                            
                                                            <div class="mt-2">
                                                                <label for="payment_receipt_{{ $penalty->id }}" class="block text-sm font-medium text-gray-700">Payment Receipt</label>
                                                                <input type="file" id="payment_receipt_{{ $penalty->id }}" name="payment_receipt" class="mt-1 form-input" required accept="image/*">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="flex justify-end">
                                                            <button type="button" onclick="document.getElementById('upload-modal-{{ $penalty->id }}').classList.add('hidden')" class="btn btn-secondary mr-2">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Upload Receipt</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Instructions</h3>
                        <p class="text-gray-700 mb-2">Please pay your penalties through one of the following methods:</p>
                        <ol class="list-decimal pl-5 text-gray-700 space-y-1">
                            <li>Bank transfer to our account: Bank XYZ 123456789 (Library App)</li>
                            <li>Cash payment at our library's circulation desk</li>
                            <li>Mobile banking or e-wallet payment</li>
                        </ol>
                        <p class="text-gray-700 mt-2">After payment, please upload the payment receipt using the "Upload Payment" button.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Paid Penalties -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Payment History</h2>
                
                @if($paidPenalties->isEmpty())
                    <div class="text-center py-6 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">No payment history found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($paidPenalties as $penalty)
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
                                                    <div class="text-sm font-medium text-gray-900">{{ $penalty->bookBorrow->book->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $penalty->days_late }} days late</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            Rp {{ number_format($penalty->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $penalty->paid_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($penalty->payment_receipt)
                                                <a href="{{ Storage::url($penalty->payment_receipt) }}" target="_blank" class="text-primary-600 hover:text-primary-900">View Receipt</a>
                                            @else
                                                <span class="text-gray-500">No receipt</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $paidPenalties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection