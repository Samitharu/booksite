@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    @if(count($cart) == 0)
        <p>Your cart is empty.</p>
    @endif

    <div class="space-y-4">
        @php $total = 0; @endphp

        @foreach($cart as $id => $item)
            @php 
                // FIXED: use quantity instead of qty
                $itemTotal = $item['price'] * $item['quantity']; 
                $total += $itemTotal;
            @endphp

            <div class="flex items-center gap-4 bg-white shadow rounded p-4">

                @if($item['image'])
                <img src="{{ asset('storage/'.$item['image']) }}" class="h-16 w-16 object-cover rounded">
                @endif

                <div class="flex-1">
                    <h2 class="text-lg font-bold">{{ $item['title'] }}</h2>

                    <!-- FIXED: replaced qty with quantity -->
                    <p>Rs.{{ $item['price'] }} × {{ $item['quantity'] }}</p>

                    <p class="font-semibold mt-1">
                        Item Total: Rs.{{ number_format($itemTotal, 2) }}
                    </p>
                </div>

                <form method="POST" action="{{ route('cart.remove', $id) }}">
                    @csrf 
                    @method('DELETE')
                    <button class="text-red-600 hover:underline">Remove</button>
                </form>
            </div>
        @endforeach
    </div>

    @if(count($cart) > 0)
    <div class="mt-6 text-right">
        <h2 class="text-xl font-bold mb-4">Total: Rs.{{ number_format($total,2) }}</h2>

        <a href="{{ route('cart.checkout') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
            Proceed to Checkout
        </a>
    </div>
    @endif

</div>
@endsection
