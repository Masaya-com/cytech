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

    <form id="search-form" method="GET" action="{{ route('products.index') }}">
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
            <div class="d-flex flex-wrap col-md-6">
                <div class="col-sm-3 col-md-2 mb-3">
                    <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
                </div>
                <div class="col-sm-3 col-md-2 mb-3">
                    <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
                </div>
                <div class="col-sm-3 col-md-2 mb-3">
                    <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
                </div>
                <div class="col-sm-3 col-md-2 mb-3">
                    <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
                </div>
            </div>
            <div class="col-md-2 d-inline">
                <button type="submit" class="btn btn-primary mt-4">検索</button>
            </div>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
    </div>

    <div id="product-table-area">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => (request('sort') == 'id' && request('direction') == 'asc') ? 'desc' : 'asc']) }}">
                            ID
                        </a>
                    </th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => (request('sort') == 'price' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"> 
                            価格
                        </a>
                    </th>
                    <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => (request('sort') == 'stock' && request('direction') == 'asc') ? 'desc' : 'asc']) }}"> 
                            在庫数
                        </a>
                    </th>
                    <th>メーカー名</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr data-product-id="{{ $product->id }}">
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
                        <td>{{ number_format($product->stock) }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a>
                            <button type="button" class="btn btn-danger btn-sm btn-async-delete" data-id="{{ $product->id }}">削除</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>  
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    // 検索フォームの非同期送信
    $(function() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const params = $form.serialize();
            $.ajax({
                url: $form.attr('action'),
                type: 'GET',
                data: params,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(html) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('product-table-area');
                    $('#product-table-area').html($(newTable).html());
                },
                error: function() {
                    alert('検索に失敗しました');
                }
            });
        });
    });

    // 削除ボタンの非同期処理
    $(function() {
        $(document).on('click', '.btn-async-delete', function() {
            const deleteConfirm = confirm('本当に削除しますか？');
            if (deleteConfirm) {
                const productId = $(this).data('id');
                const row = $(this).closest('tr');
                $.ajax({
                    url: '/products/' + productId,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function(response) {
                        row.remove();
                        alert('削除しました');
                    },
                    error: function(xhr) {
                        alert('削除に失敗しました');
                    }
                });
            }
        });
    });
</script>
@endsection