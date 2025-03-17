<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\BookRating;
use App\Models\BookReadingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan import Auth

class BookController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Basic query for books
            $booksQuery = Book::query()
                ->with(['author', 'category', 'publisher']);
            
            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $booksQuery->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhere('isbn', 'like', "%{$search}%");
                });
            }
            
            // Category filter
            if ($request->has('category') && !empty($request->category)) {
                $booksQuery->whereHas('category', function($query) use ($request) {
                    $query->where('slug', $request->category);
                });
            }
            
            // Author filter
            if ($request->has('author') && !empty($request->author)) {
                $booksQuery->whereHas('author', function($query) use ($request) {
                    $query->where('slug', $request->author);
                });
            }
            
            // Sorting
            switch ($request->sort ?? 'newest') {
                case 'oldest':
                    $booksQuery->orderBy('created_at', 'asc');
                    break;
                case 'title_asc':
                    $booksQuery->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $booksQuery->orderBy('title', 'desc');
                    break;
                case 'popular':
                    $booksQuery->orderBy('borrowed_count', 'desc');
                    break;
                default: // newest
                    $booksQuery->orderBy('created_at', 'desc');
                    break;
            }
            
            // Get paginated results
            $books = $booksQuery->paginate(12)->withQueryString();
            
            // Get categories with book counts
            $categories = Category::withCount('books')->orderBy('name')->get();
            
            // Get authors with book counts
            $authors = Author::withCount('books')->orderBy('name')->get();
            
            return view('books.index', compact('books', 'categories', 'authors'));
        } catch (\Exception $e) {
            \Log::error('Error in BookController@index: ' . $e->getMessage());
            return view('books.index', [
                'books' => collect(),
                'categories' => collect(),
                'authors' => collect(),
                'error' => 'An error occurred while loading books. Please try again.'
            ]);
        }
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)
            ->with(['author', 'category', 'publisher', 'ratings.user'])
            ->firstOrFail();

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        $userRating = null;
        // Perbaikan di sini - gunakan Auth yang telah diimpor
        if (Auth::check()) {
            $userRating = BookRating::where('book_id', $book->id)
                ->where('user_id', Auth::id()) // Gunakan Auth::id()
                ->first();
        }

        return view('books.show', compact('book', 'relatedBooks', 'userRating'));
    }

    public function storeRating(Request $request, $id)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to login to rate books.');
        }
        
        $book = Book::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        BookRating::updateOrCreate(
            [
                'user_id' => Auth::id(), // Gunakan Auth::id()
                'book_id' => $book->id,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return redirect()->back()->with('success', 'Your rating has been submitted!');
    }

    public function read($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // Perbaikan pengecekan auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to login to read books.');
        }

        // Periksa permission dengan pengecekan yang lebih aman


        // Check if book has file
        if (!$book->file_path) {
            return redirect()->back()->with('error', 'This book is not available for reading online.');
        }

        // Get or create reading session
        $readingSession = BookReadingSession::firstOrCreate(
            [
                'user_id' => Auth::id(), // Gunakan Auth::id()
                'book_id' => $book->id,
            ],
            [
                'current_page' => 1,
                'last_page_read' => 1,
                'last_read_at' => now(),
            ]
        );

        // Update last read time
        $readingSession->last_read_at = now();
        $readingSession->save();

        return view('books.read', compact('book', 'readingSession'));
    }

    public function updateReadingProgress(Request $request, $id)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        $request->validate([
            'current_page' => 'required|integer|min:1',
            'last_page_read' => 'required|integer|min:1',
        ]);

        $readingSession = BookReadingSession::where('book_id', $id)
            ->where('user_id', Auth::id()) // Gunakan Auth::id()
            ->firstOrFail();

        $readingSession->update([
            'current_page' => $request->current_page,
            'last_page_read' => $request->last_page_read,
            'last_read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}