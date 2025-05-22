<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => '商品IDは必須です',
            'quantity.required' => '数量は必須です',
        ];
    }
}
