<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\Penalty;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function index()
    {
        $activeLoans = BookBorrow::where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', 'borrowed')
            ->with('book')
            ->get();

        $history = BookBorrow::where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', '!=', 'borrowed')
            ->with('book')
            ->latest()
            ->paginate(10);

        return view('borrows.index', compact('activeLoans', 'history'));
    }

    public function create($book_id = null)
    {
        // Check if user has unpaid penalties
        $user = Auth::user();
        $hasUnpaidPenalties = Penalty::where('user_id', $user->getAuthIdentifier())
            ->where('status', 'unpaid')
            ->exists();
            
        if ($hasUnpaidPenalties) {
            return redirect()->route('penalties.index')->with('error', 'You have unpaid penalties. Please settle them before borrowing books.');
        }

        $selectedBook = null;
        if ($book_id) {
            $selectedBook = Book::findOrFail($book_id);
            
            // Check if book is available
            if (!$selectedBook->isAvailable()) {
                return redirect()->back()->with('error', 'This book is not available for borrowing.');
            }
        }

        $availableBooks = Book::whereRaw('stock > (SELECT COUNT(*) FROM book_borrows WHERE book_borrows.book_id = books.id AND book_borrows.status = "borrowed")')
            ->get();

        return view('borrows.create', compact('availableBooks', 'selectedBook'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        // Check if user has unpaid penalties
        $user = Auth::user();
        $hasUnpaidPenalties = Penalty::where('user_id', $user->getAuthIdentifier())
            ->where('status', 'unpaid')
            ->exists();
            
        if ($hasUnpaidPenalties) {
            return redirect()->route('penalties.index')->with('error', 'You have unpaid penalties. Please settle them before borrowing books.');
        }

        $book = Book::findOrFail($request->book_id);
        
        // Check if book is available
        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', 'This book is not available for borrowing.');
        }

        // Create new borrow record
        $borrow = BookBorrow::create([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'book_id' => $book->id,
            'borrow_date' => Carbon::today(),
            'due_date' => Carbon::today()->addDays(7), // 7 days loan period
            'status' => 'borrowed',
        ]);

        // Update book borrowed count
        $book->borrowed_count++;
        $book->save();

        return redirect()->route('borrows.index')->with('success', 'Book borrowed successfully. Please return it by ' . $borrow->due_date->format('d M Y'));
    }

    public function return($id)
    {
        $borrow = BookBorrow::where('id', $id)
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('status', 'borrowed')
            ->firstOrFail();

        $borrow->status = 'returned';
        $borrow->return_date = Carbon::today();
        $borrow->save();

        // Check if book is late
        if ($borrow->isOverdue()) {
            $daysLate = $borrow->getDaysLate();
            $penaltyAmount = $daysLate * 1000; // Rp1000 per day

            // Create penalty record
            $penalty = Penalty::create([
                'book_borrow_id' => $borrow->id,
                'user_id' => Auth::user()->getAuthIdentifier(),
                'amount' => $penaltyAmount,
                'days_late' => $daysLate,
                'status' => 'unpaid',
                'notes' => "Late return penalty for book: {$borrow->book->title}",
            ]);

            return redirect()->route('borrows.index')->with('warning', "Book returned but you have a late penalty of Rp " . number_format($penaltyAmount, 0, ',', '.') . ". Please settle it as soon as possible.");
        }

        return redirect()->route('borrows.index')->with('success', 'Book returned successfully. Thank you!');
    }
}