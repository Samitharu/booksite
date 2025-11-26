<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookSale;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Show HTML sales report with filters
     */
    public function salesReport(Request $request)
    {
        $books = Book::select('id', 'title')->orderBy('title')->get();

        $query = BookSale::with('book');

        // Filter: Start Date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter: End Date
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter: Book
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        $sales = $query->orderBy('created_at', 'desc')->get();

        // Total Revenue
        $totalRevenue = $sales->sum('total');

        return view('admin.reports.sales', [
            'books'        => $books,
            'sales'        => $sales,
            'totalRevenue' => $totalRevenue,
            'filters'      => $request->only(['start_date', 'end_date', 'book_id'])
        ]);
    }

    public function downloadSalesReport(Request $request)
    {
        $query = BookSale::with('book');

        // Filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        $sales = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $sales->sum('total');

        if ($sales->count() === 0) {
            return back()->with('error', 'No sales found for selected filters!');
        }

        $pdf = Pdf::loadView('admin.reports.sales_pdf', [
            'sales'        => $sales,
            'totalRevenue' => $totalRevenue,
            'filters'      => $request->only(['start_date', 'end_date', 'book_id'])
        ]);

        return $pdf->download('sales_report.pdf');
    }
}
