<html>
<head>
<style>
body { font-family: DejaVu Sans, sans-serif; }
table { width:100%; border-collapse: collapse; margin-top:20px; }
th, td { border:1px solid #000; padding:8px; text-align:left; }
th { background:#f0f0f0; }
h2 { margin-bottom: 5px; }
</style>
</head>

<body>

<h2>Invoice #{{ $invoiceId }}</h2>
<p>Date: {{ $date->format('Y-m-d H:i') }}</p>

<table>
    <thead>
        <tr>
            <th>Book</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->book->title }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>Rs.{{ number_format($sale->book->final_price, 2) }}</td>
            <td>Rs.{{ number_format($sale->total, 2) }}</td>
        </tr>
        @endforeach

        <tr>
            <th colspan="3">Grand Total</th>
            <th>Rs.{{ number_format($total, 2) }}</th>
        </tr>
    </tbody>
</table>

<p style="margin-top:20px;">Thank you for shopping with us!</p>

</body>
</html>
