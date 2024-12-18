<x-app-layout>
    <div class="dark:bg-gray-900 dark:text-gray-100">
        @if ($message = session('success'))
            <div id="success-message" class="bg-green-200 dark:bg-green-800 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
                <svg viewBox="0 0 24 24" class="text-green-600 dark:text-green-300 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path fill="currentColor"
                        d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
                    </path>
                </svg>
                <span class="text-green-800 dark:text-green-100">{{ $message }}</span>
                <button type="button" class="ml-auto text-green-600 dark:text-green-300 hover:text-green-800 dark:hover:text-green-500 focus:outline-none" aria-label="Close" onclick="closeMessage('success-message')">
                    &times;
                </button>
            </div>
        @endif

        @if ($error = session('error'))
            <div id="error-message" class="bg-red-200 dark:bg-red-800 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
                <svg viewBox="0 0 24 24" class="text-red-600 dark:text-red-300 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path fill="currentColor"
                        d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                    </path>
                </svg>
                <span class="text-red-800 dark:text-red-100">{{ $error }}</span>
                <button type="button" class="ml-auto text-red-600 dark:text-red-300 hover:text-red-800 dark:hover:text-red-500 focus:outline-none" aria-label="Close" onclick="closeMessage('error-message')">
                    &times;
                </button>
            </div>
        @endif

        <script>
            function closeMessage(id) {
                const message = document.getElementById(id);
                if (message) {
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 300);
                }
            }
            setTimeout(() => closeMessage('success-message'), 3000);
            setTimeout(() => closeMessage('error-message'), 3000);
        </script>

        <div class="w-full max-w-[1300px] mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-lg mt-4 overflow-hidden relative">
            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-2/3 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight mb-2 sm:mb-0">Shopping Cart</h2>
                        <span class="text-gray-600 dark:text-gray-400 font-medium">{{ $cartItems->count() }} Items</span>
                    </div>
                    <hr class="mb-4 border-gray-300 dark:border-gray-600">
                    <div class="hidden sm:block">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-700 dark:text-gray-300 font-bold">
                                    <th class="pb-4"></th>
                                    <th class="pb-4 text-center">Product Details</th>
                                    <th class="pb-4 text-center">Quantity</th>
                                    <th class="pb-4 text-start">Price</th>
                                    <th class="pb-4 text-center">Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="overflow-y-auto lg:overflow-hidden xl:overflow-hidden max-h-[27rem] h-auto sm:h-[27rem]">
                        <div class="w-full text-left">
                            <div class="text-gray-600 dark:text-gray-400">
                            @if($cartItems->isEmpty())
                                <div class="text-center text-gray-500 dark:text-gray-300 py-20">
                                    <h1 class="text-lg font-large">Your cart is empty!</h1>
                                </div>
                            @endif
                                @foreach($cartItems as $cartItem)
                                    @php
                                        $product = $cartItem->product;
                                        $totalPrice = $cartItem->quantity * $product->price;
                                    @endphp
                                    <div class="relative flex flex-col sm:flex-row items-center border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 p-4">
                                        <a href="{{ route('product.view', $product->id) }}"class="absolute h-full w-full z-10"></a>
                                        <div class="flex items-center justify-between w-full sm:w-auto mb-4 sm:mb-0">
                                            <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST" class="sm:mr-4 z-20">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-200 transition-colors duration-200">
                                                    <svg class="w-5 h-5 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <div class="flex items-center space-x-4">
                                                @foreach (json_decode($product->image, true) as $key => $image)
                                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="rounded-md object-cover {{ $key === 0 ? 'block' : 'hidden' }}" style="height: 80px; width:90px; object-fit: cover;">
                                                @endforeach
                                                <div class="flex flex-col">
                                                    <p class="mb-2 font-semibold text-gray-800 dark:text-gray-100">{{ $product->name }}</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @if ($cartItem->color)
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Color: {{ $cartItem->color }}</p>
                                                        @endif
                                                        @if ($cartItem->size)
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">Size: {{ $cartItem->size }}</p>
                                                        @endif
                                                        @if(!$cartItem->color && !$cartItem->size)
                                                            <p class="text-sm w-[150px]"></p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center w-full sm:w-auto space-x-4 sm:ml-auto">
                                            <div class="text-center sm:w-24">{{ $cartItem->quantity }}</div>
                                            <div class="text-start font-medium sm:w-28">₱{{ number_format($product->price, 2) }}</div>
                                            <div class="text-end font-bold text-gray-800 dark:text-gray-100 sm:w-28">₱{{ number_format($totalPrice, 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="block mt-4 sm:absolute bottom-0 left-2 font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-500 hover:underline transition-colors duration-200 sm:bottom-6 sm:left-8">&larr; Continue Shopping</a>
                </div>

                <div class="w-full lg:w-1/3 bg-gray-50 dark:bg-gray-800 p-4 sm:p-8">
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight mb-4">Order Summary</h2>
                    <hr class="mb-6 border-gray-300 dark:border-gray-600">
                    <div class="space-y-4 max-h-[7rem] overflow-y-auto">
                        @foreach($cartItems as $cartItem)
                            @php
                                $product = $cartItem->product;
                                $totalPrice = $cartItem->quantity * $product->price;
                            @endphp
                            <div class="flex flex-col sm:flex-row justify-between">
                                <div class="mb-2 sm:mb-0">
                                    <span class="flex font-semibold text-gray-800 dark:text-gray-100">{{ $product->name }} (x{{ $cartItem->quantity }})</span>
                                    <div class="flex flex-wrap gap-2">
                                        @if ($cartItem->color)
                                            <span class="text-gray-800 dark:text-gray-800">| Color: {{$cartItem->color}}</span>
                                        @endif
                                        @if ($cartItem->size)
                                            <span class="text-gray-800 dark:text-gray-800">| Size: {{$cartItem->size}} |</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <hr class="my-4 border-gray-300 dark:border-gray-600">
                    <div class="flex justify-between font-medium">
                        <span>Sub Total</span>
                        <span class="font-bold">₱{{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->product->price; }), 2) }}</span>
                    </div>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Shipping</label>
                            <select id="shipping-option" name="shipping_option" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-3">
                                <option value="standard" data-fee="20">Standard Delivery - ₱20.00</option>
                                <option value="express" data-fee="55">Express Delivery - ₱55.00</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="promo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Promo Code</label>
                            <div class="flex gap-2 w-full">
                                <input id="promo" type="text" name="promo_code" class="w-[65%] sm:w-[85%] md:w-[70%] lg:w-[73%] xl:w-[73%] border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-3 flex-1 focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-600 focus:border-slate-900 dark:focus:border-slate-500 transition-all duration-200" placeholder="Enter promo code">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 dark:bg-red-400 dark:hover:bg-red-500 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 sm:w-auto w-[120px]">Apply</button>
                            </div>
                            <p id="promo-feedback" class="mt-2 text-sm"></p>
                        </div>

                        <div class="border-t dark:border-gray-600 mt-6 pt-6">
                            <div class="flex justify-between text-lg font-bold text-gray-800 dark:text-gray-100">
                                <span>Total</span>
                                <span id="cart-total">₱{{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->product->price; }) + 20, 2) }}</span>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 dark:bg-slate-500 text-white py-3 mt-4 rounded-lg text-md font-semibold hover:bg-slate-800 focus:outline-none shadow-lg hover:shadow-xl transition-all duration-200">
                                Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shippingSelect = document.getElementById('shipping-option');
            const cartTotalElement = document.getElementById('cart-total');
            const cartSubtotal = {{ $cartItems->sum(function($item) { return $item->quantity * $item->product->price; }) }};
            shippingSelect.addEventListener('change', () => {
                const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
                const shippingFee = parseFloat(selectedOption.dataset.fee || 0);
                const totalAmount = cartSubtotal + shippingFee;
                cartTotalElement.textContent = `₱${totalAmount.toFixed(2)}`;
            });
        });
    </script>

</x-app-layout>
