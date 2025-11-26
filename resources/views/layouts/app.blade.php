<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            {{-- Navigation Bar --}}
            @include('layouts.navigation')

            {{-- Optional Page Heading (used by some admin pages) --}}
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Main Page Content --}}
            <main class="py-6">
                @yield('content')
            </main>

        </div>

        <!-- ==============================
        FOOTER SECTION
=============================== -->
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Brand -->
            <div>
                <h2 class="text-xl font-bold text-white">BookSite</h2>
                <p class="text-gray-400 mt-2 text-sm">
                    Your favorite place to buy books online.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white">Home</a></li>
                    <li><a href="#" class="hover:text-white">Categories</a></li>
                    <li><a href="/cart" class="hover:text-white">Cart</a></li>
                    <li><a href="/login" class="hover:text-white">Login</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-white font-semibold mb-3">Contact</h3>
                <p class="text-gray-400 text-sm">
                    Email: support@booksite.com<br>
                    Phone: +94 77 123 4567
                </p>
            </div>

        </div>

        <hr class="border-gray-700 my-6">

        <p class="text-center text-gray-500 text-sm">
            © {{ date('Y') }} BookStore. All rights reserved.
        </p>

    </div>
</footer>

        
    </body>
</html>
