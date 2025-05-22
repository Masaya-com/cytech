<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // 商品一覧の表示

    public function index(Request $request)
    {
        $companies = Company::all();
        $query = Product::query();

        if($product_search = $request->product_search){
            $query->where('product_name', 'LIKE', "%{$product_search}%");
        }
        
        if($company_search = $request->company_id){
            $query->where('company_id', '=', "$company_search");
        }

        if($min_price = $request->min_price){
            $query->where('price', '>=', $min_price);
        }

        if($max_price = $request->max_price){
            $query->where('price', '<=', $max_price);
        }

        if($min_stock = $request->min_stock){
            $query->where('stock', '>=', $min_stock);
        }  

        if($max_stock = $request->max_stock){
            $query->where('stock', '<=', $max_stock);
        }

        if($sort = $request->sort){
            $direction = $request->direction == 'desc' ? 'desc' : 'asc'; 
            $query->orderBy($sort, $direction);
        }

        $products = $query->get();
        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();

        return view('products.create', compact('companies'));
    }


    // データの保存と作成


    public function store(ProductRequest $request)
    {
        try {

            $product = new Product($request->validated());
    
            if ($request->hasFile('img_path')) { 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }
            
            $product->save();
            
            return redirect('products')->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '商品登録中にエラーが発生しました: ' . $e->getMessage());
        }
    }


    // 商品の詳細表示

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 商品の編集画面表示

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    // 商品情報の変更

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->fill($request->validated());

            if ($request->hasFile('img_path')) { 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }
    
            $product->save();
           
            return redirect()->route('products.index')->with('success', '商品情報を更新しました。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '商品更新中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    // 商品の削除

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect('products')->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '商品削除中にエラーが発生しました: ' . $e->getMessage());
        }
    }
  
}