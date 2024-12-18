<x-app-layout>
    <div>
        <div class="bg-white dark:bg-gray-800 shadow-md flex flex-wrap items-center justify-between p-4 lg:px-6 space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-4 width-full sm:justify-between">
                <p class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">List of Products</p>
                <div>
                    <a href="{{ route('products.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 focus:outline-none flex items-center">Add Product</a>
                </div>
            </div>
            <div>
                <form class="flex items-center w-full lg:w-auto space-x-2" method="GET" action="{{ route('products.index') }}">
                    <div class="relative">
                        <input type="text" name="search" class="flex-grow rounded-l-md border border-gray-300 w-full pl-10 pr-4 py-2 focus:ring-1 focus:ring-slate-800 lg:flex-none lg:w-64" placeholder="Search..." value="{{ request('search') }}" />
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-r-md hover:bg-slate-800 focus:outline-none">Search</button>
                    <div class="flex items-center space-x-2">
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
                                            <option value="sold_asc" {{ request('sort') == 'sold_asc' ? 'selected' : '' }}>Sold: Low to High</option>
                                            <option value="sold_desc" {{ request('sort') == 'sold_desc' ? 'selected' : '' }}>Sold: High to Low</option>
                                            <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock: Low to High</option>
                                            <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock: High to Low</option>
                                            <option value="ratings" {{ request('sort') == 'ratings' ? 'selected' : '' }}>Highest Rated</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-6 space-x-2">
                                    <a href="{{ route('products.index') }}" class="w-full sm:w-auto border border-gray-300 hover:bg-slate-100 text-black px-6 py-3 rounded-lg font-medium">Clear</a>
                                    <button class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-medium">
                                        Apply Filters
                                    </button>
                                </div>
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

    <div class="overflow-x-auto shadow">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-800 text-white text-sm uppercase">
                    <th class="py-4 px-6">Product</th>
                    <th class="py-4 px-6">Price</th>
                    <th class="py-4 px-6">Details</th>
                    <th class="py-4 px-6">Variants</th>
                    <th class="py-4 px-6">Ratings</th>
                    <th class="py-4 px-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('product.view', $product->id) }}'">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-4">
                                @foreach (json_decode($product->image, true) ?? [] as $key => $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg {{ $key === 0 ? 'block' : 'hidden' }}">
                                @endforeach
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                @if ($product->discounted_price && $product->discounted_price < $product->price)
                                    <span class="line-through text-gray-500">₱{{ number_format($product->price, 2) }}</span>
                                    <div class="font-bold text-lg">₱{{ number_format($product->discounted_price, 2) }}</div>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                        {{ $product->discount }}% OFF
                                    </span>
                                @else
                                    <div class="font-bold text-lg">₱{{ number_format($product->price, 2) }}</div>
                                @endif
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <h1 class="text-lg font-semibold">{{ $product->name }}</h1>
                                <p class="text-sm text-gray-600" style="max-width: 20rem; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $product->description }}
                                </p>
                                @if ((int)$product->stock > 5)
                                    <div class="self-start">
                                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Stock: <span>{{ $product->stock }}</span></span>
                                    </div>
                                @elseif ((int)$product->stock > 0 && (int)$product->stock <= 5)
                                    <div class="self-start">
                                        <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">Low Stock: <span>{{ $product->stock }}</span></span>
                                    </div>
                                @else
                                    <div class="self-start">
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
                                    </div>
                                @endif
                                <div class="self-start">
                                    <span class="bg-gray-800 text-white text-xs px-2 py-1 rounded">Sold: <span>{{ $product->sold }}</span></span>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <div class="text-sm text-gray-600">
                                    Color: <span>{{ implode(', ', json_decode($product->colors)) }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    Sizes: <span>{{ implode(', ', json_decode($product->size)) }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-6">

                            <div class="flex items-center mb-1">
                                @if ($product->ratings > 0)
                                    @for ($i = 0; $i < floor($product->ratings); $i++)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @endfor
                                    @if ($product->ratings - floor($product->ratings) >= 0.5)
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                    @endif
                                @elseif ($product->reviews == 0)
                                    <span class="text-sm text-gray-600">No rating</span>
                                @endif
                            </div>

                            @if ($product->reviews > 0)
                                <span class="text-sm text-gray-600">{{ $product->reviews }} reviews</span>
                            @endif

                            @if ($product->category !== 'NONE')
                                <div class="self-start">
                                    <span class="
                                        text-xs font-semibold px-2 py-1 mb-2 rounded
                                        @if ($product->category === 'BEST SELLER') bg-yellow-500 text-white
                                        @elseif ($product->category === 'FEATURED') bg-blue-500 text-white
                                        @elseif ($product->category === 'NEW') bg-green-500 text-white
                                        @else bg-gray-300 text-gray-700
                                        @endif
                                    ">
                                        {{ $product->category }}
                                    </span>
                                </div>
                            @endif
                        </td>

                        <td class="py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

</x-app-layout>
