@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">📦 Stock Report</h1>

    <!-- Filters -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        <select name="category_id" class="border rounded px-3 py-2">
            <option value="">All Categories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <select name="author_id" class="border rounded px-3 py-2">
            <option value="">All Authors</option>
            @foreach($authors as $a)
                <option value="{{ $a->id }}" @selected(request('author_id') == $a->id)>
                    {{ $a->name }}
                </option>
            @endforeach
        </select>

        <select name="publisher_id" class="border rounded px-3 py-2">
            <option value="">All Publishers</option>
            @foreach($publishers as $p)
                <option value="{{ $p->id }}" @selected(request('publisher_id') == $p->id)>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>

        <select name="out_of_stock" class="border rounded px-3 py-2">
            <option value="">Any Stock</option>
            <option value="1" @selected(request('out_of_stock')=='1')>Out of Stock Only</option>
        </select>

        <button class="col-span-full px-4 py-2 bg-indigo-600 text-white rounded">
            Filter
        </button>
    </form>

    <!-- Table -->
    <div class="bg-white shadow p-4 rounded">
        <table class="w-full text-left border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Book</th>
                    <th class="p-2 border">Author</th>
                    <th class="p-2 border">Publisher</th>
                    <th class="p-2 border">Category</th>
                    <th class="p-2 border">Stock</th>
                </tr>
            </thead>

            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="p-2 border">{{ $book->title }}</td>
                    <td class="p-2 border">{{ $book->author->name }}</td>
                    <td class="p-2 border">{{ $book->publisher->name }}</td>
                    <td class="p-2 border">{{ $book->category->name ?? '' }}</td>

                    <td class="p-2 border {{ $book->stock <= 0 ? 'text-red-600 font-bold' : '' }}">
                        {{ $book->stock }}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.stock.report.download', request()->query()) }}"
           class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700">
            Download PDF
        </a>
    </div>
</div>
@endsection
