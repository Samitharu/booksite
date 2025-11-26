<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookSale;

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
    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Your cart is empty.');
    }

    $invoiceId = time(); // unique invoice number

    foreach ($cart as $bookId => $item) {

        BookSale::create([
            'invoice_id' => $invoiceId,
            'book_id'    => $bookId,
            'price'      => $item['price'],
            'quantity'   => $item['quantity'],
            'total'      => $item['price'] * $item['quantity'],
        ]);

        // Deduct stock
        $book = Book::find($bookId);
        if ($book) {
            $book->stock -= $item['quantity'];
            $book->save();
        }
    }

    // Clear cart
    session()->forget('cart');

    return redirect()->route('invoice.download', $invoiceId);
}


//download invoice
public function downloadInvoice($invoiceId)
{
    $sales = BookSale::where('invoice_id', $invoiceId)
        ->with('book')
        ->get();

    if ($sales->isEmpty()) {
        abort(404, 'Invoice not found');
    }

    $total = $sales->sum('total');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice.pdf', [
        'invoiceId' => $invoiceId,
        'sales'     => $sales,
        'total'     => $total,
        'date'      => now(),
    ]);

    return $pdf->download("Invoice_{$invoiceId}.pdf");
}


    
}
