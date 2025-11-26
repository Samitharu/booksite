<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author','publisher'])->paginate(10);
        return view('admin.books.index', compact('books'));
    }

   public function create()
{
    $authors = Author::all();
    $publishers = Publisher::all();
    $categories = Category::all();

    return view('admin.books.create', compact('authors', 'publishers', 'categories'));
}
    public function store(Request $request)
{
    $data = $request->validate([
        'title'            => 'required|string',
        'author_id'        => 'required|exists:authors,id',
        'publisher_id'     => 'required|exists:publishers,id',
        'price'            => 'required|numeric|min:0',
        'discount_percent' => 'nullable|integer|min:0|max:100',
        'stock'            => 'required|integer|min:0',
        'description'      => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'cover_image'      => 'nullable|image|max:4096',
        'images.*'         => 'nullable|image|max:4096',  
    ]);

   
    if ($request->hasFile('cover_image')) {
        $data['cover_image'] = $request->file('cover_image')
            ->store('covers', 'public');
    }

   
    $images = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $path = $img->store('books', 'public');
            $images[] = $path;
        }
    }

    $data['images'] = $images;  

    
    Book::create($data);

    return redirect()->route('admin.books.index')
        ->with('success', 'Book created successfully.');
}


    public function edit(Book $book)
{
    $authors = Author::all();
    $publishers = Publisher::all();
    $categories = Category::all();

    return view('admin.books.edit', compact('book', 'authors', 'publishers', 'categories'));
}

   public function update(Request $request, Book $book)
{
    $data = $request->validate([
        'title'            => 'required|string',
        'author_id'        => 'required|exists:authors,id',
        'publisher_id'     => 'required|exists:publishers,id',
        'price'            => 'required|numeric|min:0',
        'discount_percent' => 'nullable|integer|min:0|max:100',
        'stock'            => 'required|integer|min:0',
        'description'      => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'cover_image'      => 'nullable|image|max:4096',
        'images.*'         => 'nullable|image|max:4096',
        'delete_images'    => 'array',
    ]);

   //cover image
    if ($request->hasFile('cover_image')) {

        
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
    }

   //extra images
    $existingImages = $book->images ?? [];

    // Delete selected images
    if ($request->delete_images) {
        foreach ($request->delete_images as $index) {
            if (isset($existingImages[$index])) {
                Storage::disk('public')->delete($existingImages[$index]);
                unset($existingImages[$index]);
            }
        }
        $existingImages = array_values($existingImages); // reindex
    }

    // Upload new images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $existingImages[] = $img->store('books', 'public');
        }
    }

    $data['images'] = $existingImages;

   //save book
    $book->update($data);

    return redirect()->route('admin.books.index')
                     ->with('success', 'Book updated successfully.');
}


    public function destroy(Book $book)
    {
        if ($book->cover_image)
            Storage::disk('public')->delete($book->cover_image);

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted.');
    }
}
