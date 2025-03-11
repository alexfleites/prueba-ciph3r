<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with('currency')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'currency_id' => 'required|integer',
            'tax_cost' => 'required|numeric',
            'manufacturing_cost' => 'required|numeric',
        ]);

        $product = Producto::create($validated);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Producto::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'currency_id' => 'sometimes|required|integer',
            'tax_cost' => 'sometimes|required|numeric',
            'manufacturing_cost' => 'sometimes|required|numeric',
        ]);

        $product = Producto::findOrFail($id);
        $product->update($validated);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Producto::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }

    /** Producto Precio Endpoints */
    public function storePrice(Request $request, $id)
    {
        $validated = $request->validate([
            'currency_id' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $product = Producto::findOrFail($id);
        $product->prices()->create($validated);
        return response()->json($product->prices()->latest()->first(), 201);
    }

    public function showPrices($id)
    {
        $product = Producto::findOrFail($id);
        return response()->json($product->prices);
    }
}