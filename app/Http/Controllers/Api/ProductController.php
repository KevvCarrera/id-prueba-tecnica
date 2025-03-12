<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAll();

        $data = $products->isEmpty()
            ? ['message' => 'No se encontraron productos']
            : $products;

        return response()->json($data, 200);
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productRepository->create($request->validated());

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

    public function show($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json($product, 200);
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $updated = $this->productRepository->update($id, $request->validated());

            if (!$updated) {
                return response()->json([
                    'message' => 'Error al actualizar el producto'
                ], 500);
            }

            $product = $this->productRepository->findById($id);

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

    public function destroy($id)
    {
        try {
            $deleted = $this->productRepository->delete($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Error al eliminar el producto'
                ], 500);
            }

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
