<?php

namespace App\Repositories;

use App\Models\Sale;

interface SaleRepositoryInterface
{
    public function getAllSales();
    public function createSale(array $data): Sale;
    public function findSaleById(int $id): ?Sale;
    public function updateSale(int $id, array $data): bool;
    public function deleteSale(int $id): bool;
}
