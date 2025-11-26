<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2> Sales Report</h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Book</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $s)
        <tr>
            <td>{{ $s->created_at->format('Y-m-d') }}</td>
            <td>{{ $s->book->title }}</td>
            <td>{{ $s->quantity }}</td>
            <td>Rs.{{ number_format($s->price, 2) }}</td>
            <td>Rs.{{ number_format($s->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 style="text-align:right; margin-top:20px;">
    Total Revenue: Rs.{{ number_format($totalRevenue, 2) }}
</h3>

</body>
</html>
