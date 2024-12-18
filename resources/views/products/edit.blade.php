<x-app-layout>
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
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Product</h2>
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="name" placeholder="Product Name" required aria-label="Product Name">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="price" placeholder="Price" step="0.01" required aria-label="Price">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="discounted_price" class="block text-sm font-medium text-gray-700">Discounted Price</label>
                        <input type="number" name="discounted_price" value="{{ $product->discounted_price }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="discounted_price" placeholder="Discounted Price" step="0.01" aria-label="Discounted Price">
                    </div>
                    <div>
                        <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                        <input type="number" name="discount" value="{{ $product->discount }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="discount" placeholder="Discount Percentage" step="0.01" aria-label="Discount Percentage">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category (Optional)</label>
                        <select name="category" id="category" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="NONE" {{ $product->category == 'NONE' ? 'selected' : '' }}>NONE</option>
                            <option value="BEST SELLER" {{ $product->category == 'BEST SELLER' ? 'selected' : '' }}>Best Seller</option>
                            <option value="NEW" {{ $product->category == 'NEW' ? 'selected' : '' }}>New</option>
                            <option value="FEATURED" {{ $product->category == 'FEATURED' ? 'selected' : '' }}>Featured</option>
                        </select>
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="stock" placeholder="Stock Quantity" step="1" min="0" aria-label="Stock Quantity">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color Variants</label>
                    <div class="flex gap-2">
                        <select id="colorSelect" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 text-sm">
                            <option value="">Select Color</option>
                            <option value="Pink">Pink</option>
                            <option value="Red">Red</option>
                            <option value="Blue">Blue</option>
                            <option value="Green">Green</option>
                            <option value="Yellow">Yellow</option>
                            <option value="Black">Black</option>
                            <option value="White">White</option>
                        </select>
                        <button type="button" onclick="addVariant('color')" class="w-[130px] bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 focus:outline-none">Add Color</button>
                    </div>
                    <div id="colorList" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Size Variants</label>
                    <div class="flex gap-2">
                        <select id="sizeSelect" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 text-sm">
                            <option value="">Select Size</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="X-Large">X-Large</option>
                        </select>
                        <button type="button" onclick="addVariant('size')" class="w-[130px] bg-slate-900 text-white px-4 py-2 rounded-md hover:bg-slate-800 focus:outline-none">Add Size</button>
                    </div>
                    <div id="sizeList" class="mt-3 flex flex-wrap gap-2"></div>
                </div>

                <input type="hidden" name="colors" id="colorsField" value="{{ $product->colors }}">
                <input type="hidden" name="sizes" id="sizesField" value="{{ $product->size }}">

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="ratings" class="block text-sm font-medium text-gray-700">Ratings</label>
                        <input type="number" name="ratings" value="{{ $product->ratings }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="ratings" placeholder="Ratings (0-5)" step="0.1" min="0" max="5" aria-label="Ratings">
                    </div>
                    <div>
                        <label for="reviews" class="block text-sm font-medium text-gray-700">Reviews</label>
                        <input type="number" name="reviews" value="{{ $product->reviews }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="reviews" placeholder="Number of Reviews" step="1" min="0" aria-label="Reviews">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (optional)</label>
                    <textarea name="description" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" id="description" rows="4" placeholder="Product Description" aria-label="Product Description">{{ $product->description }}</textarea>
                </div>

                <div class="mt-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Product Images (up to 4)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md upload-box">
                        <div class="space-y-1 text-center">
                            <div class="d-flex flex-wrap justify-content-center mb-3" id="imagePreviewContainer">
                                @foreach (json_decode($product->image, true) as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Image Preview" class="image-preview">
                                @endforeach
                            </div>
                            <input type="file" name="image[]" class="sr-only" id="image" accept="image/*" multiple onchange="previewImages(event)" aria-label="Product Images">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload files</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 mt-6">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                    <button type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800 focus:outline-none">
                        <span id="buttonText">Update Product</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="alert" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-red-500 text-white px-4 py-2 rounded-md shadow-md">
    <span class="font-medium">You can only select up to 4 images.</span>
</div>

<script>
    const variants = {
        color: [],
        size: []
    };

    function addVariant(type) {
        const select = document.getElementById(`${type}Select`);
        const value = select.value.trim();

        if (value && !variants[type].includes(value)) {
            if (variants[type].length < 5) {
                variants[type].push(value);
                updateVariantList(type);
                select.value = '';

                document.getElementById(`${type}sField`).value = JSON.stringify(variants[type]);
            } else {
                alert(`You can only add up to 5 ${type}s.`);
            }
        } else if (variants[type].includes(value)) {
            alert(`${type} "${value}" already exists.`);
        }
    }

    function updateVariantList(type) {
        const list = document.getElementById(`${type}List`);
        list.innerHTML = '';

        variants[type].forEach(value => {
            const variantElement = document.createElement('div');
            variantElement.className = 'inline-flex items-center bg-gray-100 rounded-full px-3 py-1 mb-2';

            variantElement.innerHTML = `
                <span class="text-sm text-gray-700">${value}</span>
                <button class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            `;

            variantElement.querySelector('button').addEventListener('click', () => {
                removeVariant(type, value);
            });

            list.appendChild(variantElement);
        });
    }

    function removeVariant(type, value) {
        variants[type] = variants[type].filter(item => item !== value);

        updateVariantList(type);

        document.getElementById(`${type}sField`).value = JSON.stringify(variants[type]);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const preSelectedColors = JSON.parse(document.getElementById('colorsField').value || '[]');
        const preSelectedSizes = JSON.parse(document.getElementById('sizesField').value || '[]');

        variants.color = preSelectedColors;
        variants.size = preSelectedSizes;

        updateVariantList('color');
        updateVariantList('size');
    });

    function previewImages(event) {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const alertBox = document.getElementById('alert');
        imagePreviewContainer.innerHTML = "";
        const files = Array.from(event.target.files).slice(0, 4);

        if (event.target.files.length > 4) {
            event.target.value = "";
            imagePreviewContainer.innerHTML = "";
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 3000);
            return;
        }

        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.display = 'block';
                img.style.maxHeight = '150px';
                img.style.width = 'auto';
                img.style.margin = '5px';
                img.style.objectFit = 'cover';
                img.classList.add('image-preview');
                imagePreviewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

<style>
    #imagePreviewContainer {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .image-preview {
        max-height: 150px;
        border: 1px solid #ddd;
        padding: 5px;
        background: #f8f8f8;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    #image {
        display: none;
    }

    .upload-box {
        transition: border-color 0.3s ease;
        cursor: pointer;
        border: 2px dashed #ccc;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .upload-box:hover {
        border-color: #0069d9;
    }

    .upload-box svg {
        transition: color 0.3s ease;
    }

    .upload-box:hover svg {
        color: #0069d9;
    }
</style>
</x-app-layout>
