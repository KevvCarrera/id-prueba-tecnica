<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class SaleReportController extends Controller
{
    /**
     * Generar reporte de ventas en JSON o Excel
     */
    public function generateReport(Request $request)
    {
        // Validar fechas
        $request->validate(rules: [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:json,xlsx'
        ]);

        // Filtrar ventas por fecha
        $sales = Sale::whereBetween('sale_datetime', [$request->start_date, $request->end_date])
            ->get(['code', 'customer_name', 'customer_id', 'customer_email', 'products', 'total_amount', 'sale_datetime']);

        // Formatear cantidad de productos vendidos
        $sales->transform(function ($sale) {
            $sale->products_count = collect(json_decode($sale->products, true))->sum('quantity');
            unset($sale->products); // Eliminar campo 'products'
            return $sale;
        });

        // Retornar en JSON
        if ($request->format === 'json') {
            return response()->json($sales);
        }

        // Exportar en Excel
        return Excel::download(new SalesExport($sales), 'sales_report.xlsx');
    }
}
