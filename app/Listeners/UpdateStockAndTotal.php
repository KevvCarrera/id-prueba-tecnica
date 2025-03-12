<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStockAndTotal implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaleCreated $event)
    {
        $sale = $event->sale;
        $totalAmount = 0;

        foreach ($sale->products as $productData) {
            $product = Product::find($productData['id']);

            if ($product && $product->stock >= $productData['quantity']) {
                $product->decrement('stock', $productData['quantity']);
                $totalAmount += $product->price * $productData['quantity'];
            } else {
                throw new \Exception("Error crítico: Se intentó vender un producto sin stock suficiente (ID {$productData['id']}).");
            }
        }

        $sale->update(['total_amount' => $totalAmount]);
    }
}
