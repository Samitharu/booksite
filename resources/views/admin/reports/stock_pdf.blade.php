<html>
<head>
    <style>
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:8px; }
        th { background:#eee; }
    </style>
</head>
<body>

<h2>Stock Report</h2>

<table>
    <thead>
        <tr>
            <th>Book</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Category</th>
            <th>Stock</th>
        </tr>
    </thead>

    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name }}</td>
            <td>{{ $book->publisher->name }}</td>
            <td>{{ $book->category->name ?? '' }}</td>
            <td>{{ $book->stock }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
