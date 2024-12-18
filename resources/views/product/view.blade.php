<x-app-layout>
    <div class="mt-4 mb bg-white px-2 py-2 mx-auto rounded-lg grid grid-cols-1 md:grid-cols-2" style="width: 80%">
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
            setTimeout(() => closeMessage('success-message'), 5000);
            setTimeout(() => closeMessage('error-message'), 5000);
        </script>

        <div class="p-8 sm:pr-8 lg:pr-0 text-right relative" style="width:100%; height:100%;">
            <div class="relative">
                <div id="productcarousel{{ $product->id }}" class="carousel flex transition-transform duration-500 ease-in-out">
                    @foreach (json_decode($product->image, true) ?? [] as $key => $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-sm {{ $key === 0 ? 'block' : 'hidden' }}">
                    @endforeach
                </div>
                <button class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full hover:bg-white" onclick="previousSlide({{ $product->id }})">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full hover:bg-white" onclick="nextSlide({{ $product->id }})">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-8 space-y-1" style="width: 100%; height:100%;">
            <div class="flex space-x-2">
                <h1 class="text-2xl text-gray-900">{{ $product->name }}</h1>
            </div>

            <div class="flex items-baseline space-x-4">
                <p class="text-2xl font-semibold text-slate-900">
                    ₱ {{ number_format($product->price, 2) }}
                    @if(!empty($product->discounted_price) && $product->discounted_price > 0)
                        <span class="text-sm text-slate-900 line-through">₱ {{ number_format($product->discounted_price, 2) }}</span>
                    @endif
                </p>
                @if($product->discount > 1)
                    <span class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded">
                        - <span>{{ $product->discount }}%</span>
                    </span>
                @endif
            </div>

            <div class="flex items-center">
                <div class="flex text-yellow-400">
                    @php
                        $fullStars = floor($product->ratings);
                        $halfStar = $product->ratings - $fullStars >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - ($fullStars + $halfStar);
                    @endphp

                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star"></i>
                    @endfor

                    @if ($halfStar)
                        <i class="fas fa-star-half-alt"></i>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star"></i>
                    @endfor
                </div>
                <span class="ml-2 text-gray-600">({{ $product->reviews }} reviews)</span>
            </div>

            <div class="space-y-1 mt-2">
                <p class="font-medium text-gray-800">Description:</p>
                <div class="text-gray-600 leading-relaxed break-words">
                    {{ $product->description }}
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex mt-2 items-center space-x-2">
                    <div class="w-4 h-4 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></div>
                    <span class="{{ $product->stock > 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                        Stock: <span>{{ $product->stock > 0 ? $product->stock : 'Out of Stock' }}</span>
                    </span>
                </div>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    @if($product->colors && is_array(json_decode($product->colors)))
                        <div class="space-y-3">
                            <p class="font-medium">Color</p>
                            <div class="flex space-x-2" id="color-options">
                                @foreach(json_decode($product->colors) as $color)
                                    <button
                                        type="button"
                                        class="px-4 py-2 border rounded-md hover:border-blue-500 focus:outline-none color-option"
                                        data-color="{{ $color }}">
                                        {{ $color }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="selected_color" id="selected-color" value="">
                    @endif

                    @if($product->size && is_array(json_decode($product->size)))
                        <div class="space-y-3 my-2">
                            <p class="font-medium">Size</p>
                            <div class="flex space-x-2" id="size-options">
                                @foreach(json_decode($product->size) as $size)
                                    <button
                                        type="button"
                                        class="px-4 py-2 border rounded-md hover:border-blue-500 focus:outline-none size-option"
                                        data-size="{{ $size }}">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="selected_size" id="selected-size" value="">
                    @endif

                    <div class="flex flex-col items-start space-y-2 my-2">
                        <label class="font-medium">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" onclick="changeQuantity(-1)" class="px-3 py-2 border-r border-gray-300 text-xl text-gray-600 hover:bg-gray-200 rounded-l-md">-</button>
                            <span id="quantity" class="font-medium text-lg text-center w-[50px]">1</span>
                            <button type="button" onclick="changeQuantity(1)" class="px-3 py-2 border-l border-gray-300 text-xl text-gray-600 hover:bg-gray-200 rounded-r-md">+</button>
                        </div>
                    </div>
                    <input type="hidden" id="hidden-quantity" name="quantity" value="1">

                    <button type="submit" id="add-to-cart"
                            data-product-id="{{ $product->id }}"
                            class="w-full py-3 rounded-lg transition duration-200 {{ $product->stock > 0 ? 'bg-slate-900 text-white hover:bg-slate-800' : 'bg-slate-700 text-white cursor-not-allowed' }}"
                            {{ $product->stock === 0 ? 'disabled' : '' }}>
                        {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let quantity = 1;

        function changeQuantity(change) {
            const quantityElement = document.getElementById('quantity');
            const hiddenQuantityInput = document.getElementById('hidden-quantity');
            const newQuantity = quantity + change;
            if (newQuantity > 0) {
                quantity = newQuantity;
                quantityElement.textContent = quantity;
                hiddenQuantityInput.value = quantity;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const selectedColorInput = document.getElementById('selected-color');
            const selectedSizeInput = document.getElementById('selected-size');

            const colorOptions = document.querySelectorAll('.color-option');
            if (colorOptions.length > 0) {
                const firstColor = colorOptions[0];
                firstColor.classList.add('border-blue-500');
                selectedColorInput.value = firstColor.dataset.color;
            }

            const sizeOptions = document.querySelectorAll('.size-option');
            if (sizeOptions.length > 0) {
                const firstSize = sizeOptions[0];
                firstSize.classList.add('border-blue-500');
                selectedSizeInput.value = firstSize.dataset.size;
            }

            colorOptions.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    colorOptions.forEach(b => b.classList.remove('border-blue-500'));
                    button.classList.add('border-blue-500');
                    selectedColorInput.value = button.dataset.color;
                });
            });

            sizeOptions.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    sizeOptions.forEach(b => b.classList.remove('border-blue-500'));
                    button.classList.add('border-blue-500');
                    selectedSizeInput.value = button.dataset.size;
                });
            });
        });

        function previousSlide(productId, carouselPrefix = 'productcarousel') {
            const carousel = document.getElementById(`${carouselPrefix}${productId}`);
            const currentIndex = Array.from(carousel.children).findIndex(child => child.classList.contains('block'));
            const nextIndex = (currentIndex === 0) ? carousel.children.length - 1 : currentIndex - 1;
            updateCarousel(carousel, nextIndex);
        }

        function nextSlide(productId, carouselPrefix = 'productcarousel') {
            const carousel = document.getElementById(`${carouselPrefix}${productId}`);
            const currentIndex = Array.from(carousel.children).findIndex(child => child.classList.contains('block'));
            const nextIndex = (currentIndex === carousel.children.length - 1) ? 0 : currentIndex + 1;
            updateCarousel(carousel, nextIndex);
        }

        function updateCarousel(carousel, nextIndex) {
            Array.from(carousel.children).forEach((child, index) => {
                child.classList.toggle('block', index === nextIndex);
                child.classList.toggle('hidden', index !== nextIndex);
            });
        }
    </script>
</x-app-layout>
