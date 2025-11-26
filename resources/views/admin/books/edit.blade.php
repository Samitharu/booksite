@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Book</h1>

    <form method="POST"
          action="{{ route('admin.books.update', $book) }}"
          enctype="multipart/form-data"
          class="space-y-6 bg-white p-6 rounded-xl shadow">

        @csrf
        @method('PUT')

        <!-- ============================
             Title
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
            <input type="text"
                   name="title"
                   value="{{ $book->title }}"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Author
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Author</label>
            <select name="author_id"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($authors as $a)
                    <option value="{{ $a->id }}" @selected($a->id == $book->author_id)>
                        {{ $a->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- ============================
             Publisher
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Publisher</label>
            <select name="publisher_id"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($publishers as $p)
                    <option value="{{ $p->id }}" @selected($p->id == $book->publisher_id)>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- ============================
             Category
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
            <select name="category_id"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($cat->id == $book->category_id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- ============================
             Price
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Price (Rs.)</label>
            <input type="number"
                   step="0.01"
                   name="price"
                   value="{{ $book->price }}"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Discount Percent
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Discount (%)</label>
            <input type="number"
                   name="discount_percent"
                   value="{{ $book->discount_percent }}"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Stock
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
            <input type="number"
                   name="stock"
                   value="{{ $book->stock }}"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Description
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ $book->description }}</textarea>
        </div>


        <!-- ============================
             Cover Image
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Cover Image</label>

            @if($book->cover_image)
                <img src="{{ asset('storage/'.$book->cover_image) }}"
                     class="h-28 rounded-lg border mb-3 object-cover">
            @else
                <p class="text-gray-500 text-sm mb-2">No cover image available.</p>
            @endif

            <input type="file"
                   name="cover_image"
                   class="w-full border-gray-300 rounded-lg px-3 py-2">
        </div>


        <!-- ============================
             MULTIPLE IMAGES
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Images</label>

            <!-- Existing Images Grid -->
            <div class="flex flex-wrap gap-3 mb-3">

                @if($book->images)
                    @foreach($book->images as $index => $img)
                        <div class="relative">
                            <img src="{{ asset('storage/'.$img) }}"
                                 class="h-20 w-20 rounded-lg border object-cover shadow">

                            <!-- Small delete tick -->
                            <label class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full cursor-pointer">
                                ✕
                                <input type="checkbox"
                                       name="delete_images[]"
                                       value="{{ $index }}"
                                       class="hidden">
                            </label>
                        </div>
                    @endforeach
                @endif

            </div>

            <!-- Upload New Images -->
            <input type="file"
                   name="images[]"
                   multiple
                   class="border-gray-300 rounded-lg px-3 py-2 w-full">
        </div>


        <!-- ============================
             SUBMIT BUTTON
        ============================ -->
        <div class="pt-4">
            <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Update Book
            </button>
        </div>

    </form>

</div>
@endsection
