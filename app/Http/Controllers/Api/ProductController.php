<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        $data = $products->isEmpty()
            ? ['message' => 'No se encontraron productos']
            : $products;

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return response()->json([
                'message' => 'Producto creado exitosamente',
                'product' => $product
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->validated());

            return response()->json([
                'message' => 'Producto actualizado con éxito',
                'product' => $product
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'El producto no existe'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'message' => 'Producto eliminado'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'El producto no existe'
            ], 404);
        }
    }
}
