@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Add New Book</h1>

    <form method="POST"
          action="{{ route('admin.books.store') }}"
          enctype="multipart/form-data"
          class="space-y-6 bg-white p-6 rounded-xl shadow">

        @csrf


        <!-- ============================
             Title
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
            <input type="text"
                   name="title"
                   placeholder="Enter book title"
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
                    <option value="{{ $a->id }}">{{ $a->name }}</option>
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
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- ============================
             Category
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
            <select name="category_id"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>


        <!-- ============================
             Price
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Price (Rs.)</label>
            <input type="number"
                   name="price"
                   step="0.01"
                   placeholder="Enter price"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Discount Percent
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Discount (%)</label>
            <input type="number"
                   name="discount_percent"
                   placeholder="Enter discount (optional)"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Stock
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
            <input type="number"
                   name="stock"
                   placeholder="Enter stock quantity"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>


        <!-- ============================
             Description
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description"
                      rows="4"
                      placeholder="Write a brief description about the book"
                      class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>


        <!-- ============================
             Cover Image
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Image</label>
            <input type="file"
                   name="cover_image"
                   class="w-full border-gray-300 rounded-lg px-3 py-2">
        </div>


        <!-- ============================
             Additional Images
        ============================ -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Images</label>
            <input type="file"
                   name="images[]"
                   multiple
                   class="w-full border-gray-300 rounded-lg px-3 py-2">
        </div>


        <!-- ============================
             SUBMIT BUTTON
        ============================ -->
        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Save Book
            </button>
        </div>

    </form>

</div>
@endsection
