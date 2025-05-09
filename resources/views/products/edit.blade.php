@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <h1>商品情報編集画面</h1>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="product_id">ID</label>
            <input type="text" id="product_id" class="form-control" value="{{ $product->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="product_name">商品名<span class="text-danger">*</span></label>
            <input type="text" id="product_name" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
        </div>

        <div class="form-group">
            <label for="company_id">メーカー名 <span class="text-danger">*</span></label>
            <select name="company_id" id="company_id" class="form-control">
                <option value="">選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">価格<span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="stock">在庫数<span class="text-danger">*</span></label>
            <input type="number" id="stock" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea id="comment" name="comment" class="form-control">{{ $product->comment }}</textarea>
        </div>

        <div class="form-group">
            <label for="img_path">商品画像</label>
            <input type="file" id="img_path" name="img_path" class="form-control">
            @if($product->img_path)
                <img src="{{ asset($product->img_path) }}" alt="商品画像" width="100" class="mt-2">
            @endif
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
@endsection