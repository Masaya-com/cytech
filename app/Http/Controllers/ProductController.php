<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

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
        $products = $query->get();
        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();

        return view('products.create', compact('companies'));
    }


    // データの保存と作成


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required', 
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', 
            'img_path' => 'nullable|image',
        ]);

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);



        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();
        
        return redirect('products');
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
    
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
       
        return redirect()->route('products.index');    
    }

    // 商品の削除

    public function destroy(Product $product)
        {
            $product->delete();
    
            return redirect('products');
        }
  
}