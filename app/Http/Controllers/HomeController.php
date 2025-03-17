<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::where('is_featured', true)
            ->with(['author', 'category'])
            ->take(6)
            ->get();
            
        $latestBooks = Book::latest()
            ->with(['author', 'category'])
            ->take(8)
            ->get();
            
        $popularBooks = Book::orderBy('borrowed_count', 'desc')
            ->with(['author', 'category'])
            ->take(8)
            ->get();
            
        $categories = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('featuredBooks', 'latestBooks', 'popularBooks', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function faq()
    {
        return view('faq');
    }

    public function contact()
    {
        return view('contact');
    }
}