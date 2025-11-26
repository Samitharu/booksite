@extends('layouts.app')

@section('content')

<!-- =========================
     HERO BANNER
========================= -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-600 py-20 text-white rounded-xl mt-4">

    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
            Discover Your Next Great Book
        </h1>

        <p class="text-lg text-indigo-100 mb-8">
            Explore thousands of books from top authors and publishers.
        </p>

        <!-- Search Bar Inside Hero -->
        <form method="GET" action="{{ route('books.index') }}" class="w-full md:w-1/2 relative">

            <input type="text"
                   name="q"
                   id="searchInput"
                   placeholder="Search by title"
                   class="w-full px-5 py-3 rounded-full text-gray-800 shadow-lg">

            <!-- Suggestions Box -->
            <div id="searchSuggestions"
                 class="hidden absolute left-0 right-0 bg-white shadow-lg rounded-lg text-gray-700 mt-2 z-50">
            </div>

        </form>

    </div>

</section>


<!-- =========================
     CATEGORY FILTER BAR
========================= -->
@if($categories->count() > 0)
<div class="max-w-7xl mx-auto px-4 mt-10">

    <h2 class="text-2xl font-bold mb-4">Browse by Category</h2>

    <div class="flex flex-wrap gap-3">

        @foreach($categories as $cat)
            <a href="{{ route('books.index', ['category' => $cat->id]) }}"
               class="px-4 py-2 bg-gray-200 hover:bg-indigo-600 hover:text-white rounded-full text-sm">
                {{ $cat->name }}
            </a>
        @endforeach

    </div>

</div>
@endif


<!-- =========================
     FEATURED / LATEST BOOKS
========================= -->
<div class="max-w-7xl mx-auto px-4 mt-12">

    <h2 class="text-2xl font-bold mb-6">Latest Books</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        @foreach($books as $book)
        <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

            <a href="{{ route('books.show', $book) }}">
                <img src="{{ asset('storage/'.$book->cover_image) }}"
                     class="h-60 w-full object-cover hover:scale-105 transition duration-300">
            </a>

            <div class="p-5">
                <h3 class="text-lg font-semibold">{{ $book->title }}</h3>
                <p class="text-sm text-gray-500">{{ $book->author->name }}</p>

                <div class="mt-3 flex items-center gap-2">
                    @if($book->discount_percent > 0)
                        <span class="line-through text-gray-400 text-sm">
                            Rs.{{ number_format($book->price, 2) }}
                        </span>
                        <span class="text-indigo-600 font-bold">
                            Rs.{{ number_format($book->final_price, 2) }}
                        </span>
                    @else
                        <span class="text-indigo-600 font-bold">
                            Rs.{{ number_format($book->price, 2) }}
                        </span>
                    @endif
                </div>

                <p class="mt-1 text-sm {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $book->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </p>

                <a href="{{ route('books.show', $book) }}"
                   class="block mt-4 text-center bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                    View Details
                </a>
            </div>
        </div>
        @endforeach

    </div>

    <div class="mt-10 pb-10">
        {{ $books->onEachSide(1)->links() }}
    </div>

</div>



<!-- =========================
     LIVE SEARCH SCRIPT
========================= -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let query = this.value.trim();

    if (query.length < 2) {
        document.getElementById("searchSuggestions").classList.add("hidden");
        return;
    }

    fetch(`/search-books?q=` + query)
        .then(res => res.json())
        .then(data => {
            let box = document.getElementById("searchSuggestions");

            if (data.length === 0) {
                box.innerHTML = "<p class='p-4 text-gray-500'>No results found.</p>";
            } else {
                box.innerHTML = data.map(book =>
                    `<a href="/books/${book.id}" class="block px-4 py-2 hover:bg-gray-100">
                        ${book.title}
                    </a>`
                ).join('');
            }

            box.classList.remove("hidden");
        });
});
</script>

@endsection
