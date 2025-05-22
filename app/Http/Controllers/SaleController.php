<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Sale; 
use App\Http\Requests\SaleRequest;

class SaleController extends Controller
{
    public function sale(SaleRequest $request)
    {
        try {
            $validated = $request->validated();
            $productId = $validated['product_id'];
            $quantity = $validated['quantity'];
            $product = Product::find($productId);

            if ($product->stock < $quantity) {
                return response()->json(['message' => '商品が在庫不足です'], 400);
            }

            $product->stock -= $quantity;
            $product->save();

            $sale = new Sale([
                'product_id' => $productId,
            ]);
            $sale->save();

            return response()->json(['message' => '購入成功']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'エラーが発生しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}



