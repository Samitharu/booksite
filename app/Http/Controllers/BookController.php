<?php
namespace App\Http\Controllers;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function index(Request $request)
{
    $query = Book::query();

    if ($request->has('q')) {
        $query->where('title', 'like', '%' . $request->q . '%');
    }

    if ($request->has('category')) {
        $query->where('category_id', $request->category);
    }

    $books = $query->latest()->paginate(12);

    $categories = \App\Models\Category::all();

    return view('books.index', compact('books', 'categories'));
}


    public function show(Book $book)
    {
        $book->load(['author', 'publisher']);

        /*  $sameAuthorBooks = Book::where('author_id', $book->author_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(3)
            ->get();

        $samePublisherBooks = Book::where('publisher_id', $book->publisher_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(3)
            ->get(); */

       $sameAuthorBooks = $book->author
        ->books()
        ->where('id', '!=', $book->id)
        ->latest()
        ->take(3)
        ->get();

    $samePublisherBooks = $book->publisher
        ->books()
        ->where('id', '!=', $book->id)
        ->latest()
        ->take(3)
        ->get();

        return view('books.show', compact('book', 'sameAuthorBooks', 'samePublisherBooks'));
    }
}
