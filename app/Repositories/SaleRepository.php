<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllSales()
    {
        return Sale::with('user')->latest()->get();
    }

    public function createSale(array $data): Sale
    {
        return Sale::create($data);
    }

    public function findSaleById(int $id): ?Sale
    {
        return Sale::with('user')->find($id);
    }

    public function updateSale(int $id, array $data): bool
    {
        $sale = Sale::findOrFail($id);
        return $sale->update($data);
    }

    public function deleteSale(int $id): bool
    {
        $sale = Sale::findOrFail($id);
        return $sale->delete();
    }
}
