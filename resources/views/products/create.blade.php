@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録画面</h1>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="product_name">商品名<span class="text-danger">*</span></label>
            <input type="text" id="product_name" name="product_name" class="form-control" placeholder="商品名を入力" required>
        </div>

        <div class="form-group">
            <label for="company_id">メーカー名<span class="text-danger">*</span></label>
            <select id="company_id" name="company_id" class="form-control" required>
                <option value="">選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">価格<span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" placeholder="価格を入力" required>
        </div>

        <div class="form-group">
            <label for="stock">在庫数<span class="text-danger">*</span></label>
            <input type="number" id="stock" name="stock" class="form-control" placeholder="在庫数を入力" required>
        </div>

        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea id="comment" name="comment" class="form-control" placeholder="コメントを入力"></textarea>
        </div>

        <div class="form-group">
            <label for="img_path">商品画像</label>
            <input type="file" id="img_path" name="img_path" class="form-control">
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">新規登録</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
@endsection