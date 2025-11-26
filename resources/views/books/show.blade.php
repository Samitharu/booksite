@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="grid md:grid-cols-2 gap-10">

        <!-- ==========================
             IMAGE GALLERY SECTION
        =========================== -->
        <div x-data="{ 
                activeImage: '{{ asset('storage/'.$book->cover_image) }}' 
            }">

            <!-- Main Large Image -->
            <img
                :src="activeImage"
                class="w-full h-96 object-cover rounded shadow mb-4 transition-all duration-300">

            <!-- Thumbnails -->
            <div class="flex flex-wrap gap-3">

                <!-- Cover image thumbnail -->
                <img
                    src="{{ asset('storage/' . $book->cover_image) }}"
                    class="h-20 w-20 object-cover rounded cursor-pointer border hover:opacity-75"
                    @click="activeImage = '{{ asset('storage/' . $book->cover_image) }}'">

                <!-- Extra uploaded images -->
                @if($book->images)
                @foreach($book->images as $img)
                <img
                    src="{{ asset('storage/' . $img) }}"
                    class="h-20 w-20 object-cover rounded cursor-pointer border hover:opacity-75"
                    @click="activeImage = '{{ asset('storage/' . $img) }}'">
                @endforeach
                @endif

            </div>

        </div>

        <!-- ==========================
             BOOK INFO SECTION
        =========================== -->
        <div>

            <h1 class="text-4xl font-bold">{{ $book->title }}</h1>

            <p class="text-gray-500 text-lg mt-1">
                by {{ $book->author->name }}
            </p>

            <!-- Price + Discount -->
            <div class="my-5">
                @if($book->discount_percent > 0)
                <span class="line-through text-gray-400 text-lg">
                    Rs.{{ number_format($book->price, 2) }}
                </span>

                <span class="text-indigo-600 text-3xl font-extrabold ml-3">
                    Rs.{{ number_format($book->final_price, 2) }}
                </span>

                <span class="text-red-500 ml-2 font-semibold">
                    -{{ $book->discount_percent }}%
                </span>
                @else
                <span class="text-indigo-600 text-3xl font-extrabold">
                    Rs.{{ number_format($book->price, 2) }}
                </span>
                @endif
            </div>

            <!-- Stock -->
            <p class="font-semibold mb-4">
                @if($book->stock > 0)
                <span class="text-green-600">In Stock: {{ $book->stock }}</span>
                @else
                <span class="text-red-600">Out of Stock</span>
                @endif
            </p>


            <!-- Add to Cart Form -->
            <!-- Add to Cart Form -->
            @if($book->stock > 0)
            <form action="{{ route('cart.add', $book->id) }}" method="POST" class="mt-4">
                @csrf

                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                    Quantity
                </label>

                <div class="flex items-center gap-3">

                    <input
                        type="number"
                        name="quantity"
                        id="quantity"
                        min="1"
                        max="{{ $book->stock }}"
                        value="1"
                        class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Add to Cart
                    </button>

                </div>

                <!-- FRONTEND Red Error Message -->
                <p id="qtyError" class="text-red-600 text-sm font-medium mt-2 hidden">
                    You cannot add more than {{ $book->stock }} items.
                </p>

                <!-- BACKEND Red Error Message -->
                @if(session('error'))
                <p class="text-red-600 text-sm font-medium mt-2">
                    {{ session('error') }}
                </p>
                @endif
            </form>

            <script>
                document.getElementById('quantity').addEventListener('input', function() {
                    let max = parseInt(this.max);
                    let val = parseInt(this.value);

                    const msg = document.getElementById('qtyError');

                    if (val > max) {
                        this.value = max;
                        msg.classList.remove('hidden'); // show red error line
                    } else {
                        msg.classList.add('hidden'); // hide if valid
                    }
                });
            </script>
            @endif


            <hr class="my-6">

            <!-- Description -->
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $book->description }}
            </p>

        </div>
    </div>
</div>

<!-- ================================================
     RELATED BOOKS SECTION
================================================ -->

<div class="max-w-6xl mx-auto px-4 mt-12">

    <!-- ============================
         SAME AUTHOR – Latest 1 book
    ============================= -->
    @if($sameAuthorBooks->count() > 0)
    <h2 class="text-2xl font-bold mb-4">More by {{ $book->author->name }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($sameAuthorBooks as $aBook)
        <a href="{{ route('books.show', $aBook->id) }}" class="block">
            <div class="rounded shadow hover:shadow-lg transition overflow-hidden bg-white">

                <img src="{{ asset('storage/' . $aBook->cover_image) }}"
                    class="h-40 w-full object-cover">

                <div class="p-3">
                    <h3 class="font-semibold text-gray-800 text-sm">
                        {{ $aBook->title }}
                    </h3>

                    <p class="text-xs text-gray-500">{{ $aBook->author->name }}</p>

                    <p class="text-indigo-600 font-bold mt-1">
                        Rs.{{ number_format($aBook->final_price, 2) }}
                    </p>
                </div>

            </div>
        </a>
        @endforeach

    </div>
    @endif

    <!-- Spacing -->
    <div class="my-10"></div>

    <!-- ============================
         SAME PUBLISHER – Latest 3 books
    ============================= -->
    @if($samePublisherBooks->count() > 0)
    <h2 class="text-2xl font-bold mb-4">More from {{ $book->publisher->name }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($samePublisherBooks as $pBook)
        <a href="{{ route('books.show', $pBook->id) }}" class="block">
            <div class="rounded shadow hover:shadow-lg transition overflow-hidden bg-white">

                <img src="{{ asset('storage/' . $pBook->cover_image) }}"
                    class="h-40 w-full object-cover">

                <div class="p-3">
                    <h3 class="font-semibold text-gray-800 text-sm">
                        {{ $pBook->title }}
                    </h3>

                    <p class="text-xs text-gray-500">{{ $pBook->author->name }}</p>

                    <p class="text-indigo-600 font-bold mt-1">
                        Rs.{{ number_format($pBook->final_price, 2) }}
                    </p>
                </div>

            </div>
        </a>
        @endforeach

    </div>
    @endif

</div>





@endsection