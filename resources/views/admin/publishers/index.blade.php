@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">

    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Publishers</h1>
        <a href="{{ route('admin.publishers.create') }}"
           class="px-4 py-2 bg-gray-800 text-white rounded">+ Add</a>
    </div>

    <div class="bg-white shadow border rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Website</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($publishers as $publisher)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $publisher->name }}</td>
                    <td class="px-4 py-2">{{ $publisher->website }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.publishers.edit', $publisher) }}" class="text-blue-600">Edit</a>
                        |
                        <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-3">{{ $publishers->links() }}</div>
    </div>

</div>
@endsection
