<x-app-layout>
    <div>
        <div class="bg-white dark:bg-gray-800 shadow-md flex flex-wrap items-center justify-between p-4 lg:px-24 space-y-4 lg:space-y-0">
            <p class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">List of Products</p>
            <div>
                <form class="flex items-center w-full lg:w-auto space-x-2" method="GET" action="{{ route('dashboard') }}">
                    <div class="relative">
                        <input type="text" name="search" class="flex-grow rounded-l-md border border-gray-300 w-full pl-10 pr-4 py-2 focus:ring-1 focus:ring-slate-800 lg:flex-none lg:w-64" placeholder="Search..." value="{{ request('search') }}" />
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-r-md hover:bg-slate-800 focus:outline-none">Search</button>
                    <div class="inline-block relative">
                        <button id="filterButton" type="button" class="bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 focus:outline-none flex items-center">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>

                        <div id="filterSection" class="hidden absolute right-0 top-full mt-2 bg-white rounded-lg shadow-xl border border-gray-200 p-4 md:p-6 z-50 w-[300px] sm:w-[600px] lg:w-[800px]">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category" class="w-full rounded-lg border border-gray-300 py-2.5 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">All Categories</option>
                                        <option value="BEST SELLER" {{ request('category') == 'BEST SELLER' ? 'selected' : '' }}>BEST SELLER</option>
                                        <option value="FEATURED" {{ request('category') == 'FEATURED' ? 'selected' : '' }}>FEATURED</option>
                                        <option value="NEW" {{ request('category') == 'NEW' ? 'selected' : '' }}>NEW</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Price Range</label>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input type="number" name="min_price" placeholder="Min" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('min_price') }}">
                                        <input type="number" name="max_price" placeholder="Max" class="w-full rounded-lg border border-gray-300 py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('max_price') }}">
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Sort By</label>
                                    <select name="sort" class="w-full rounded-lg border border-gray-300 py-2.5 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Newest to Oldest</option>
                                        <option value="oldest_desc" {{ request('sort') == 'oldest_desc' ? 'selected' : '' }}>Oldest to Newest</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="ratings" {{ request('sort') == 'ratings' ? 'selected' : '' }}>Highest Rated</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6 space-x-2">
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto border border-gray-300 hover:bg-slate-100 text-black px-6 py-3 rounded-lg font-medium">Clear</a>
                                <button class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-medium">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const filterButton = document.getElementById("filterButton");
            const filterSection = document.getElementById("filterSection");

            filterButton.addEventListener("click", (e) => {
                e.stopPropagation();
                filterSection.classList.toggle("hidden");
            });

            filterSection.addEventListener("click", (e) => {
                e.stopPropagation();
            });

            document.addEventListener("click", () => {
                if (!filterSection.classList.contains("hidden")) {
                    filterSection.classList.add("hidden");
                }
            });
        </script>

    @if ($message = session('success'))
        <div id="success-message" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
            <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor"
                    d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
                </path>
            </svg>
            <span class="text-green-800">{{ $message }}</span>
            <button type="button" class="ml-auto text-green-600 hover:text-green-800 focus:outline-none" aria-label="Close" onclick="closeMessage('success-message')">
                &times;
            </button>
        </div>
    @endif

    @if ($error = session('error'))
        <div id="error-message" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center w-[80] transition-opacity duration-300 opacity-1" role="alert">
            <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor"
                    d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                </path>
            </svg>
            <span class="text-red-800">{{ $error }}</span>
            <button type="button" class="ml-auto text-red-600 hover:text-red-800 focus:outline-none" aria-label="Close" onclick="closeMessage('error-message')">
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

    <div class="flex justify-center mt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-4">
            @if($products->isEmpty())
                <p class="col-span-full text-center text-lg text-gray-500">No products yet.</p>
            @endif
            @foreach ($products as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-xs mx-auto relative" style="height: 500px; width:400px">
                @if($product->stock <= 0)
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center z-10 text-center">
                        <span class="text-white text-xl font-semibold">SOLD OUT</span>
                    </div>
                @else
                <div class="absolute inset-0 flex items-center justify-center z-10 text-center">
                    <a href="{{ route('product.view', $product->id) }}" class="absolute z-8 w-full h-full"></a>
                </div>
                @endif
                <div class="relative">
                    @if(isset($product->discount) && $product->discount > 0)
                        <span class="absolute top-0 left-0 w-28 translate-y-4 pr-2 -translate-x-6 -rotate-45 bg-gray-800 text-center text-sm text-white">
                            {{ $product->discount }}% Off
                        </span>
                    @endif
                    @if(!empty($product->category) && trim(strtolower($product->category)) !== 'none')
                        <span class="absolute top-0 right-0 m-2 rounded-full bg-blue-400 px-2 text-center text-sm font-medium text-white">
                            {{ $product->category }}
                        </span>
                    @endif
                        <div id="productcarousel{{ $product->id }}" class="carousel flex transition-transform duration-500 ease-in-out">
                            @foreach (json_decode($product->image, true) as $key => $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover {{ $key === 0 ? 'block' : 'hidden' }}">
                            @endforeach
                        </div>
                        <button class="absolute z-20 left-2 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full hover:bg-white" onclick="previousSlide({{ $product->id }})">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="absolute z-20 right-2 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full hover:bg-white" onclick="nextSlide({{ $product->id }})">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl tracking-tight text-slate-900"">{{ $product->name }}</h2>
                                <p class="text-2xl font-semibold text-slate-900">
                                    ₱ {{ number_format($product->price, 2) }}
                                    @if(!empty($product->discounted_price) && $product->discounted_price > 0)
                                        <span class="text-sm text-slate-900 line-through">₱ {{ number_format($product->discounted_price, 2) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <p class="text-gray-600 line-clamp-2 mb-4 break-words" style="overflow: hidden; height:70px;">{{ $product->description }}</p>
                        <div class="flex justify-between">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <p class="ms-2 text-sm font-bold text-gray-900 dark:text-white">
                                    {{ number_format($product->ratings, 2) }}
                                </p>
                                <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"></span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->reviews }} reviews</span>
                            </div>
                            {{-- <div class="mt-auto flex justify-end">
                                <a href="{{ route('product.view', $product->id) }}" class="bg-slate-900 z-20 text-white px-3 py-2 rounded-lg hover:bg-slate-800">View Product</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

<script>
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

<style>
    .carousel { display: flex; transition: transform 0.6s ease-in-out; }
    .carousel img {
        flex-shrink: 0;
        width: 100%;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    </style>
</x-app-layout>
