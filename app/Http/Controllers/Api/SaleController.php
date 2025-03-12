<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Models\Product;
use App\Events\SaleCreated;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function index(): JsonResponse
    {
        $sales = Sale::with('user')->latest()->get();
        return response()->json($sales);
    }

    public function store(SaleRequest $request): JsonResponse
    {
        // Crear la venta con los datos validados
        $sale = Sale::create($request->validated());

        // Disparar el evento para calcular el total y actualizar stock
        event(new SaleCreated($sale));

        return response()->json(['message' => 'Venta registrada con éxito', 'sale' => $sale], 201);
    }

    public function show($id): JsonResponse
    {
        $sale = Sale::with('user')->find($id);

        if (!$sale) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        return response()->json($sale);
    }

    public function destroy($id): JsonResponse
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $sale->delete();

        return response()->json(['message' => 'Venta eliminada con éxito']);
    }
}
