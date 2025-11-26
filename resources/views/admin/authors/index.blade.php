@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Authors</h1>
        <a href="{{ route('admin.authors.create') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded bg-gray-800 text-white hover:bg-gray-900">
            + New Author
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-sm text-green-700 border border-green-300 rounded px-3 py-2 bg-green-50">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm border rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        #
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bio
                    </th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($authors as $author)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ $author->id }}
                        </td>
                        <td class="px-4 py-2 text-sm font-medium text-gray-900">
                            {{ $author->name }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit($author->bio, 60) }}
                        </td>
                        <td class="px-4 py-2 text-sm text-right">
                            <a href="{{ route('admin.authors.edit', $author) }}"
                               class="text-blue-600 hover:underline mr-2">
                                Edit
                            </a>

                            <form action="{{ route('admin.authors.destroy', $author) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this author?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                            No authors found. Create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3">
            {{ $authors->links() }}
        </div>
    </div>
</div>
@endsection
