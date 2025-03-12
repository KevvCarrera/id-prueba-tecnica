<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Services\SaleServiceInterface;
use Illuminate\Http\JsonResponse;

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
     * Muestra una lista de todas las ventas.
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
