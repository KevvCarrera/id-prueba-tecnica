<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'customer_name' => $this->customer_name,
            'customer_id' => $this->customer_id,
            'customer_email' => $this->customer_email,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'total_amount' => $this->total_amount,
            'sale_datetime' => $this->sale_datetime->toDateTimeString(),
            'products' => ProductResource::collection(collect($this->products)->map(function ($product) {
                return \App\Models\Product::find($product['id']);
            })->filter()), 
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
