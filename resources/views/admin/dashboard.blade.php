@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-2">
        Admin Dashboard
    </h1>
    <p class="text-gray-500 mb-8">
        Manage your bookstore content and monitor activity.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Books --}}
        <a href="{{ route('admin.books.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    📚
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Manage Books</h3>
                    <p class="text-sm text-gray-500">Add, edit and organize books.</p>
                </div>
            </div>
        </a>

        {{-- Authors --}}
        <a href="{{ route('admin.authors.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    ✍️
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Manage Authors</h3>
                    <p class="text-sm text-gray-500">Create and edit author profiles.</p>
                </div>
            </div>
        </a>

        {{-- Publishers --}}
        <a href="{{ route('admin.publishers.index') }}"
           class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    🏢
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Manage Publishers</h3>
                    <p class="text-sm text-gray-500">Organize and maintain publishers.</p>
                </div>
            </div>
        </a>

        {{-- Orders --}}
        <a href="#" class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    🧾
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Orders</h3>
                    <p class="text-sm text-gray-500">View and manage customer orders.</p>
                </div>
            </div>
        </a>

        {{-- Sales Reports --}}
        <a href="{{ route('admin.sales.report') }}" class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                    📈
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Sales Reports</h3>
                    <p class="text-sm text-gray-500">Track revenue and performance.</p>
                </div>
            </div>
        </a>

        {{-- Stock Report --}}
        <a href="{{ route('admin.stock.report') }}"
           class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition transform flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    📦
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Stock Report</h3>
                    <p class="text-sm text-gray-500">Check inventory and low-stock items.</p>
                </div>
            </div>
        </a>

    </div>
</div>
@endsection
