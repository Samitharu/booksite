@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8">

    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Books</h1>
        <a href="{{ route('admin.books.create') }}"
           class="px-4 py-2 bg-gray-800 text-white rounded">+ Add</a>
    </div>

    <div class="bg-white shadow border rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Author</th>
                    <th class="px-4 py-2 text-left">Publisher</th>
                    <th class="px-4 py-2 text-left">Stock</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($books as $book)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $book->title }}</td>
                    <td class="px-4 py-2">{{ $book->author->name }}</td>
                    <td class="px-4 py-2">{{ $book->publisher->name }}</td>
                    <td class="px-4 py-2">{{ $book->stock }}</td>

                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-600">Edit</a>
                        |
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-3">{{ $books->links() }}</div>
    </div>

</div>
@endsection
