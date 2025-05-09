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
    <h1 class = "mb-3">商品一覧画面</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="product_search">検索キーワード</label>
                <input type="text" name="product_search" id="product_search" class="form-control" placeholder="商品名を入力">
            </div>
            <div class="col-md-4 mb-3">
                <label for="company_id">メーカー名</label>
                <select name="company_id" id="company_id" class="form-control">
                    <option value="">選択してください</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary mt-4">検索</button>
            </div>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
    </div>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->img_path)
                            <img src="{{ asset($product->img_path) }}" alt="商品画像">
                        @else
                            画像なし
                            
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>¥{{ number_format($product->price) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" class = "d-inline"  onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>  
</div>
@endsection