<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_id',
        'customer_email',
        'user_id',
        'total_amount',
        'products',
        'sale_datetime'
    ];

    protected $casts = [
        'products' => 'array',
        'sale_datetime' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

}
