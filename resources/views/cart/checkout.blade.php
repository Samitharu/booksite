@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    @php
    $total = 0;
    foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
    }
    @endphp

    <div class="bg-white shadow p-6 rounded">

        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

        <div class="space-y-3 mb-6">
            @foreach($cart as $item)
            <div class="flex justify-between border-b pb-2">
                <span>{{ $item['title'] }} (x {{ $item['quantity'] }})</span>
                <span>Rs.{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
            </div>
            @endforeach
        </div>

        <div class="text-right text-xl font-bold mb-6">
            Total: Rs.{{ number_format($total, 2) }}
        </div>

        <h2 class="text-xl font-semibold mb-4">Payment Details</h2>

        <form action="{{ route('cart.processCheckout') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Card Holder Name</label>
                <input type="text" name="card_name" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
            </div>

            <div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Card Number</label>

                    <div class="flex items-center border border-gray-300 rounded-md shadow-sm px-3">

                        <input
                            type="text"
                            name="card_number"
                            id="card_number"
                            maxlength="16"
                            required
                            class="w-full border-0 focus:ring-0"
                            oninput="detectCardType(this.value)">


                        <img id="card_logo" src="" class="h-6 w-auto ml-2">
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Expiry Date</label>
                    <input type="text" name="expiry" placeholder="MM/YY" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">CVV</label>
                    <input type="password" name="cvv" maxlength="3" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">
                Pay & Complete Order
            </button>
        </form>

        <script>
function detectCardType(number) {
    const logo = document.getElementById('card_logo');

    // Remove spaces
    number = number.replace(/\D/g, '');

    // Visa starts with 4
    if (/^4/.test(number)) {
        logo.src = "https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg";
        return;
    }

    // MasterCard starts with 51–55 or 2221–2720
    if (/^(5[1-5])/.test(number) || /^(222[1-9]|22[3-9]\d|2[3-6]\d{2}|27[01]\d|2720)/.test(number)) {
        logo.src = "https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png";
        return;
    }

    // Unknown or empty → hide logo
    logo.src = "";
}
</script>


    </div>

</div>
@endsection