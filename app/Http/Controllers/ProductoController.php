<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Divisa;
use App\Models\ProductoPrecio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::all();
        return response()->json([
            'status' => 'success',
            'data' => $productos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate currency existence first
        $currency = Divisa::find($request->currency_id);
        if (!$currency) {
            return response()->json([
                'status' => 'error',
                'message' => 'Currency not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:divisas,id',
            'tax_cost' => 'required|numeric|min:0',
            'manufacturing_cost' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();

        $producto = Producto::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $producto->with('user', 'currency', 'prices')->first()
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $producto->with('user', 'currency', 'prices')->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        // Check if user owns the product
        if ($producto->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update this product'
            ], 403);
        }

        // If currency_id is being updated, validate its existence
        if ($request->has('currency_id')) {
            $currency = Divisa::find($request->currency_id);
            if (!$currency) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Currency not found'
                ], 404);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'currency_id' => 'sometimes|required|exists:divisas,id',
            'tax_cost' => 'sometimes|required|numeric|min:0',
            'manufacturing_cost' => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $producto->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $producto->with('user', 'currency', 'prices')->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Display all prices associated with a product.
     */
    public function showPrices($id): JsonResponse
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $prices = $producto->prices()->with('currency')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'product' => [
                    'id' => $producto->id,
                    'name' => $producto->name
                ],
                'prices' => $prices
            ]
        ]);
    }

    /**
     * Store new prices for a product.
     * If currency doesn't exist, it will be created.
     */
    public function storePrices(Request $request, $id): JsonResponse
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'currency_id' => 'required|exists:divisas,id',
            'price' => 'required|numeric|min:10',
            'symbol' => 'string|max:3',
            'name' => 'string|max:255',
            'exchange_rate' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Find or create currency
            if($request->name){
                $currency = Divisa::firstOrCreate(
                    ['name' => $request->name],
                    [
                        'name' => $request->name,
                        'symbol' => $request->symbol,
                        'exchange_rate' => $request->exchange_rate
                    ]
                );
            }

            // Create price
            $price = ProductoPrecio::create([
                'product_id' => $producto->id,
                'currency_id' => $request->name ? $currency->id : $request->currency_id,
                'price' => $request->price
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Prices created successfully',
                'data' => [
                    'product' => [
                        'id' => $producto->id,
                        'name' => $producto->name
                    ],
                    'prices' => $producto->prices
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create prices',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
