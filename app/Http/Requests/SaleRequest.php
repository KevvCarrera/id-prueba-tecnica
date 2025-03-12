<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'nullable|string|unique:sales,code|max:50',
            'customer_name' => 'required|string|max:255',
            'customer_id' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'nullable|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.id' => [
                'required',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1]; 
                    $quantity = request()->input("products.$index.quantity");
                    $product = Product::find($value);

                    if ($product && $product->stock < $quantity) {
                        $fail("Stock insuficiente para el producto ID {$value}.");
                    }
                }
            ],
            'products.*.quantity' => 'required|integer|min:1',
            'sale_datetime' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'code.unique' => 'El código de la venta debe ser único.',
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_id.required' => 'El ID del cliente es obligatorio.',
            'customer_email.email' => 'Debe ingresar un correo electrónico válido.',
            'user_id.exists' => 'El usuario vendedor no existe.',
            'products.required' => 'Debe incluir al menos un producto en la venta.',
            'products.*.id.exists' => 'Uno de los productos seleccionados no existe.',
            'products.*.quantity.min' => 'La cantidad de productos debe ser al menos 1.',
            'sale_datetime.date_format' => 'La fecha de venta debe tener el formato correcto (Y-m-d H:i:s).',
        ];
    }
}
