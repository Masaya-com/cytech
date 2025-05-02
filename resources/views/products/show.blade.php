@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報詳細画面</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID</h5>
            <p class="card-text">{{ $product->id }}</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">商品画像</h5>
            @if($product->img_path)
                <img src="{{ asset($product->img_path) }}" alt="商品画像">
            @else
                <p class="card-text">画像なし</p>
            @endif
        </div>
        <div class="card-body">
            <h5 class="card-title">商品名</h5>
            <p class="card-text">{{ $product->product_name }}</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">メーカー</h5>
            <p class="card-text">{{ $product->company->company_name }}</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">価格</h5>
            <p class="card-text">¥{{ number_format($product->price) }}</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">在庫数</h5>
            <p class="card-text">{{ $product->stock }}</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">コメント</h5>
            <p class="card-text">{{ $product->comment }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
@endsection