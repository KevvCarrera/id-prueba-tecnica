<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

/** *
 * @OA\Tag(
 *     name="Productos",
 *     description="Operaciones relacionadas con productos"
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Servidor API"
 * )
 */

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Productos"},
     *     summary="Obtener lista de productos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos obtenida exitosamente",
     *     )
     * )
     */

    public function index()
    {
        $products = $this->productRepository->getAll();

        $data = $products->isEmpty()
            ? ['message' => 'No se encontraron productos']
            : $products;

        return response()->json($data, 200);
    }

        /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Productos"},
     *     summary="Crear un nuevo producto",
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al crear el producto"
     *     )
     * )
     */

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

     /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Productos"},
     *     summary="Obtener detalles de un producto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del producto obtenidos exitosamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */

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

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     tags={"Productos"},
     *     summary="Actualizar un producto existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado con éxito",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al actualizar el producto"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"Productos"},
     *     summary="Eliminar un producto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar el producto"
     *     )
     * )
     */
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
