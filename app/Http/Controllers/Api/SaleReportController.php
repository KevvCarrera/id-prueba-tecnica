<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use Carbon\Carbon;

class SaleReportController extends Controller
{
    /**
     * Generar reporte de ventas en JSON o Excel
     */
    public function generateReport(Request $request)
    {
        // Validar parámetros de entrada
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:json,xlsx'
        ]);

        // Obtener ventas dentro del rango de fechas
        $sales = Sale::whereBetween('sale_datetime', [$validated['start_date'], $validated['end_date']])
            ->get(['code', 'customer_name', 'customer_id', 'customer_email', 'products', 'total_amount', 'sale_datetime']);

        // Formatear cantidad de productos vendidos
        $sales->transform(function ($sale) {
            if (is_string($sale->products)) {
                $products = json_decode($sale->products, true);
            } else {
                $products = $sale->products;
            }

            $sale->products_count = is_array($products) ? collect($products)->sum('quantity') : 0;
            unset($sale->products); // Eliminar campo 'products' para que no se muestre
            return $sale;
        });

        // Si se solicita en formato JSON
        if ($validated['format'] === 'json') {
            return response()->json($sales);
        }

        // Si se solicita en formato Excel
        return Excel::download(new SalesExport($sales), 'sales_report_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }
}
