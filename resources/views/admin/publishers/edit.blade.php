@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Publisher</h1>

    <div class="bg-white shadow rounded-xl p-6">

        <form method="POST"
              action="{{ route('admin.publishers.update', $publisher) }}"
              class="space-y-6">
            @csrf
            @method('PUT')

            <!-- ==============================
                 PUBLISHER NAME
            =============================== -->
            <div>
                <label for="name"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Publisher Name <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $publisher->name) }}"
                       placeholder="Enter publisher name"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm 
                              focus:ring-indigo-500 focus:border-indigo-500
                              @error('name') border-red-500 @enderror">

                @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- ==============================
                 WEBSITE
            =============================== -->
            <div>
                <label for="website"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Website (optional)
                </label>

                <input type="text"
                       id="website"
                       name="website"
                       value="{{ old('website', $publisher->website) }}"
                       placeholder="https://example.com"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm 
                              focus:ring-indigo-500 focus:border-indigo-500
                              @error('website') border-red-500 @enderror">

                @error('website')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- ==============================
                 ACTION BUTTONS
            =============================== -->
            <div class="flex justify-end gap-2">

                <a href="{{ route('admin.publishers.index') }}"
                   class="px-4 py-2 text-sm border rounded-lg bg-gray-50 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Update Publisher
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
