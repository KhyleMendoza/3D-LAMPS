<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($sort = $request->input('sort')) {
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'ratings') {
                $query->orderByDesc('ratings')->orderByDesc('reviews');
            } elseif ($sort === 'oldest_desc') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sort === 'stock_asc') {
                $query->orderBy('stock', 'asc');
            } elseif ($sort === 'stock_desc') {
                $query->orderBy('stock', 'desc');
            } elseif ($sort === 'sold_asc') {
                $query->orderBy('sold', 'asc');
            } elseif ($sort === 'sold_desc') {
                $query->orderBy('sold', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'category' => 'required|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'ratings' => 'nullable|numeric|between:0,5',
            'reviews' => 'nullable|integer|min:0',
        ]);

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('images', 'public');
                $imagePaths[] = $path;
            }
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price,
            'discount' => $request->discount,
            'description' => $request->description,
            'image' => json_encode($imagePaths),
            'category' => $request->category,
            'stock' => $request->stock ?? 0,
            'colors' => $request->colors,
            'size' => $request->sizes,
            'ratings' => $request->ratings ?? 0,
            'reviews' => $request->reviews ?? 0,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'category' => 'required|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'ratings' => 'nullable|numeric|between:0,5',
            'reviews' => 'nullable|integer|min:0',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->discounted_price = $request->discounted_price;
        $product->discount = $request->discount;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->stock = $request->stock ?? 0;
        $product->colors = $request->colors;
        $product->size = $request->sizes;
        $product->ratings = $request->ratings ?? 0;
        $product->reviews = $request->reviews ?? 0;

        if ($request->hasFile('image')) {
            foreach (json_decode($product->image, true) as $oldImage) {
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('image') as $image) {
                $path = $image->store('images', 'public');
                $imagePaths[] = $path;
            }
            $product->image = json_encode($imagePaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach (json_decode($product->image, true) as $imagePath) {
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

}
