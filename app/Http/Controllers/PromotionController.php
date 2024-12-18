<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promos = Promo::all();
        return view('promotion.index', compact('promos'));
    }

    public function create()
    {
        return view('promotion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:promos,code',
            'quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|integer|between:0,100',
        ]);

        Promo::create($request->all());

        return redirect()->route('promotion.index')->with('success', 'Promo code created successfully!');
    }

    public function show(Promo $promotion)
    {
        return view('promotion.show', compact('promotion'));
    }


    public function edit(Promo $promotion)
    {
        return view('promotion.edit', compact('promotion'));
    }

    public function update(Request $request, Promo $promotion)
    {
        $request->validate([
            'code' => 'required|unique:promos,code,' . $promotion->id,
            'quantity' => 'required|integer|min:1',
            'discount_percentage' => 'required|integer|between:0,100',
        ]);

        $promotion->update($request->all());

        return redirect()->route('promotion.index')->with('success', 'Promo code updated successfully!');
    }

    public function destroy(Promo $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotion.index')->with('success', 'Promo code deleted successfully!');
    }
}
