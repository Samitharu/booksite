@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8">

    <h1 class="text-2xl font-bold mb-6">📊 Sales Report</h1>

    <!-- Filters -->
    <form method="GET" class="bg-white p-5 rounded shadow mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="text-sm font-medium">Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="text-sm font-medium">End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="text-sm font-medium">Book</label>
            <select name="book_id" class="w-full border px-3 py-2 rounded">
                <option value="">All Books</option>
                @foreach($books as $b)
                    <option value="{{ $b->id }}" @selected(request('book_id') == $b->id)>
                        {{ $b->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded w-full hover:bg-indigo-700">
                Filter
            </button>
        </div>

    </form>

    <!-- Download PDF button -->
    <a href="{{ route('admin.sales.report.download', request()->all()) }}"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">
        📄 Download PDF
    </a>

    <!-- Results Table -->
    <div class="bg-white shadow rounded p-4">
        <table class="w-full table-auto">
            <thead>
                <tr class="border-b bg-gray-100 text-left">
                    <th class="px-2 py-2">Date</th>
                    <th class="px-2 py-2">Book</th>
                    <th class="px-2 py-2">Qty</th>
                    <th class="px-2 py-2">Price</th>
                    <th class="px-2 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $s)
                <tr class="border-b">
                    <td class="px-2 py-2">{{ $s->created_at->format('Y-m-d') }}</td>
                    <td class="px-2 py-2">{{ $s->book->title }}</td>
                    <td class="px-2 py-2">{{ $s->quantity }}</td>
                    <td class="px-2 py-2">Rs.{{ number_format($s->price, 2) }}</td>
                    <td class="px-2 py-2 font-bold">Rs.{{ number_format($s->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right mt-4 text-lg font-bold">
            Total Revenue: Rs.{{ number_format($totalRevenue, 2) }}
        </div>
    </div>

</div>

@endsection
