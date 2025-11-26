@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Add New Author</h1>

    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('admin.authors.store') }}"
              method="POST"
              class="space-y-6">

            @csrf

            <!-- ==============================
                 AUTHOR NAME
            =============================== -->
            <div>
                <label for="name"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Author Name <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter author name"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:ring-indigo-500 focus:border-indigo-500
                              @error('name') border-red-500 @enderror">

                @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- ==============================
                 AUTHOR BIO
            =============================== -->
            <div>
                <label for="bio"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Bio (optional)
                </label>

                <textarea id="bio"
                          name="bio"
                          rows="4"
                          placeholder="Enter a short biography"
                          class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm
                                 focus:ring-indigo-500 focus:border-indigo-500
                                 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>

                @error('bio')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- ==============================
                 ACTION BUTTONS
            =============================== -->
            <div class="flex justify-end gap-2 pt-2">

                <a href="{{ route('admin.authors.index') }}"
                   class="px-4 py-2 text-sm border rounded-lg bg-gray-50 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Save Author
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
