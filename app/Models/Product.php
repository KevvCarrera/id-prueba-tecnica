<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'sku',
        'name',
        'unit_price',
        'stock'
    ];

    public function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }
}
