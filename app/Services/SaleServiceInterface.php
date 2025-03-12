<?php

namespace App\Services;

use App\Models\Sale;

interface SaleServiceInterface
{
    public function getAllSales();
    public function createSale(array $data): Sale;
    public function getSaleById(int $id): ?Sale;
    public function updateSale(int $id, array $data): bool;
    public function deleteSale(int $id): bool;
}
