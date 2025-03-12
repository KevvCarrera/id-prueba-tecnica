<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Services\SaleServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;


/**
 *
 * @OA\Tag(
 *     name="Ventas",
 *     description="Operaciones relacionadas con ventas"
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Servidor API"
 * )
 */

class SaleController extends Controller
{
    protected $saleService;

    /**
     * Constructor que inyecta el servicio de ventas.
     *
     * @param SaleServiceInterface $saleService
     */
    public function __construct(SaleServiceInterface $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     *
     * @OA\Get(
     *     path="/sales",
     *     tags={"Ventas"},
     *     summary="Obtener lista de ventas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ventas obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sales = $this->saleService->getAllSales();
        return response()->json($sales);
    }

    /**
     * Almacena una nueva venta y actualiza el stock de los productos.
     *
     * @OA\Post(
     *     path="/sales",
     *     tags={"Ventas"},
     *     summary="Registrar una nueva venta",
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Venta registrada con éxito"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al registrar la venta"
     *     )
     * )
     *
     * @param SaleRequest $request
     * @return JsonResponse
     */
    public function store(SaleRequest $request): JsonResponse
    {
        try {
            $sale = $this->saleService->createSale($request->validated());
            return response()->json(['message' => 'Venta registrada con éxito', 'sale' => $sale], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al registrar la venta: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Muestra los detalles de una venta específica.
     *
     * @OA\Get(
     *     path="/sales/{id}",
     *     tags={"Ventas"},
     *     summary="Obtener detalles de una venta",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la venta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la venta obtenidos exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Venta no encontrada"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $sale = $this->saleService->getSaleById($id);

        if (!$sale) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        return response()->json($sale);
    }

    /**
     * Actualiza una venta específica.
     *
     * @OA\Put(
     *     path="/sales/{id}",
     *     tags={"Ventas"},
     *     summary="Actualizar una venta existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la venta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Venta actualizada con éxito"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error al actualizar la venta"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Venta no encontrada"
     *     )
     * )
     * @param SaleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(SaleRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->saleService->updateSale($id, $request->validated());

            if (!$updated) {
                return response()->json(['message' => 'Venta no encontrada'], 404);
            }

            return response()->json(['message' => 'Venta actualizada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la venta: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Elimina una venta específica.
     * @OA\Delete(
     *     path="/sales/{id}",
     *     tags={"Ventas"},
     *     summary="Eliminar una venta",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la veta",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Venta eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Venta no encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al eliminar la venta"
     *     )
     * )
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->saleService->deleteSale($id);

            if (!$deleted) {
                return response()->json(['message' => 'Venta no encontrada'], 404);
            }

            return response()->json(['message' => 'Venta eliminada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la venta: ' . $e->getMessage()], 400);
        }
    }
}
