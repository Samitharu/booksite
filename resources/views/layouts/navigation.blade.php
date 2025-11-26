<nav x-data="{ open:false }" class="bg-white/90 backdrop-blur border-b shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between h-16 items-center">

            <!-- LOGO -->
            <a href="{{ route('books.index') }}" class="flex items-center gap-2">
                <span class="text-2xl font-bold text-indigo-600">📚 BookStore</span>
            </a>

            <!-- DESKTOP NAV -->
            <div class="hidden md:flex items-center gap-8">

                <a href="{{ route('books.index') }}"
                   class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('cart.index') }}"
                   class="nav-link relative">
                    Cart
                    <span class="ml-1 bg-indigo-600 text-white px-2 py-0.5 text-xs rounded-full">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>

                @auth
                    @role('Admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        Admin
                    </a>
                    @endrole

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="nav-link text-red-600 hover:text-red-700">
                            Logout
                        </button>
                    </form>

                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        Login
                    </a>
                @endauth

            </div>

            <!-- MOBILE MENU BUTTON -->
            <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none">
                <svg :class="{'hidden': open, 'block': !open}" class="w-7 h-7 block" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <svg :class="{'block': open, 'hidden': !open}" class="w-7 h-7 hidden" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="md:hidden bg-white border-t shadow-sm">
        <div class="px-4 py-3 space-y-2">

            <a href="{{ route('books.index') }}" class="mobile-link">
                Home
            </a>

            <a href="{{ route('cart.index') }}" class="mobile-link">
                Cart ({{ session('cart') ? count(session('cart')) : 0 }})
            </a>

            @auth
                @role('Admin')
                <a href="{{ route('admin.dashboard') }}" class="mobile-link">
                    Admin
                </a>
                @endrole

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mobile-link text-red-600">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-link">
                    Login
                </a>
            @endauth

        </div>
    </div>
</nav>

<!-- STYLES FOR NAV -->
<style>
    .nav-link {
        @apply text-gray-700 font-medium hover:text-indigo-600 transition;
    }
    .nav-link.active {
        @apply text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1;
    }
    .mobile-link {
        @apply block w-full text-gray-700 font-medium py-2 hover:text-indigo-600;
    }
</style>
