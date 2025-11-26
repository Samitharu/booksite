<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        $query = Book::query();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->author_id) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->publisher_id) {
            $query->where('publisher_id', $request->publisher_id);
        }

        if ($request->out_of_stock == '1') {
            $query->where('stock', '<=', 0);
        }

        $books = $query->with(['author', 'publisher', 'category'])->get();

        return view('admin.reports.stock', compact('books', 'categories', 'authors', 'publishers'));
    }


    public function download(Request $request)
    {
        $query = Book::query();

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->author_id) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->publisher_id) {
            $query->where('publisher_id', $request->publisher_id);
        }

        if ($request->out_of_stock == '1') {
            $query->where('stock', '<=', 0);
        }

        $books = $query->with(['author', 'publisher', 'category'])->get();

        $pdf = Pdf::loadView('admin.reports.stock_pdf', compact('books'));

        return $pdf->download('stock_report.pdf');
    }
}
