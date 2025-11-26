<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add to cart
    public function add(Request $request, Book $book)
{
    // Sanitize quantity
    $quantity = intval($request->input('quantity', 1));
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Check against available stock
    if ($quantity > $book->stock) {
        return back()->with('error', "You cannot add more than {$book->stock} items.");
    }

    $cart = session()->get('cart', []);

    // If the item already exists in cart
    if (isset($cart[$book->id])) {

        $existingQty = $cart[$book->id]['quantity'];
        $newQty = $existingQty + $quantity;

        // Prevent exceeding stock when combined with existing cart quantity
        if ($newQty > $book->stock) {
            return back()->with('error', "Only {$book->stock} items available in stock.");
        }

        // Update quantity
        $cart[$book->id]['quantity'] = $newQty;

    } else {
        // Create cart item
        $cart[$book->id] = [
            'title'    => $book->title,
            'price'    => $book->discount_percent > 0 ? $book->final_price : $book->price,
            'image'    => $book->cover_image,
            'quantity' => $quantity,
        ];
    }

    // Save cart
    session()->put('cart', $cart);

    return back()->with('success', 'Book added to cart!');
}



    // Remove item
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // Checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('cart.checkout', compact('cart'));
    }


    //puchase process
    public function processCheckout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty.');
    }

    foreach ($cart as $id => $item) {

        $book = Book::find($id);

        // Reduce stock
        if ($book->stock < $item['quantity']) {
            return redirect()->back()->with('error', 'Not enough stock for ' . $book->title);
        }

        $book->stock -= $item['quantity'];
        $book->save();

        // Save sale record
        \App\Models\BookSale::create([
            'book_id' => $book->id,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'total' => $item['price'] * $item['quantity'],
        ]);
    }

    // Clear cart
    session()->forget('cart');

    return redirect('/')->with('success', 'Order completed successfully!');
}
    
}
