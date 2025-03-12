<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Repositories\SaleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService implements SaleServiceInterface
{
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAllSales();
    }

    public function createSale(array $data): Sale
    {
        $productsData = $data['products'];
        $totalAmount = 0;

        DB::beginTransaction();

        try {
            // Crear la venta
            $sale = $this->saleRepository->createSale([
                'code' => $data['code'],
                'customer_name' => $data['customer_name'],
                'customer_id' => $data['customer_id'],
                'customer_email' => $data['customer_email'],
                'user_id' => $data['user_id'],
                'total_amount' => 0, // Se actualizará después
                'products' => $productsData,
                'sale_datetime' => now(),
            ]);

            // Procesar cada producto de la venta
            foreach ($productsData as $productData) {
                $product = Product::find($productData['id']);

                if (!$product) {
                    throw new Exception("Producto con ID {$productData['id']} no encontrado.");
                }

                if ($product->stock < $productData['quantity']) {
                    throw new Exception("Stock insuficiente para el producto {$product->name}.");
                }

                // Disminuir el stock del producto
                $product->stock -= $productData['quantity'];
                $product->save();

                // Calcular el monto total de la venta
                $totalAmount += $product->unit_price * $productData['quantity'];
            }

            // Actualizar el monto total de la venta
            $sale->total_amount = $totalAmount;
            $sale->save();

            DB::commit();

            return $sale;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al registrar la venta: ' . $e->getMessage());
        }
    }

    public function getSaleById(int $id): ?Sale
    {
        return $this->saleRepository->findSaleById($id);
    }

    public function updateSale(int $id, array $data): bool
    {
        return $this->saleRepository->updateSale($id, $data);
    }

    public function deleteSale(int $id): bool
    {
        return $this->saleRepository->deleteSale($id);
    }
}
