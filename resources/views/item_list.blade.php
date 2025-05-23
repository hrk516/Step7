@extends('layouts.app')

@section('title')
    商品一覧画面
@endsection

@section('content')
    <div class="row">
        <form method='GET' action="{{ route('search') }}" class="d-flex align-items-center gap-2">
            @csrf
            <textarea class="form-control col-3" name="keyword" placeholder="検索キーワード"></textarea>
            <select class="form-select col-2" name="company_id" aria-label="企業選択">
                <option value="" selected>選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <label for="price" class="col-sm-auto: auto col-form-label">価格</label>
            <input type="number" class="col-sm-1" name="minPrice" value="">〜
            <input type="number" class="col-sm-1" name="maxPrice" value="">
            <label for="price" class="col-sm-auto: auto col-form-label">在庫</label>
            <input type="number" class="col-sm-1" name="minStock" value="">〜
            <input type="number" class="col-sm-1" name="maxStock" value="">
            <input class="btn btn-primary search" type="submit" value="検索" />
        </form>
    </div>

    <div class="main">
        <table class="table table-striped" id="fav-table">
            <thead>
                <tr>
                    <th scope="col" class="sorter-digit">ID</th>
                    <th scope="col">商品画像</th>
                    <th scope="col">商品名</th>
                    <th scope="col">価格</th>
                    <th scope="col">在庫数</th>
                    <th scope="col">メーカー名</th>
                    <th scope="col">
                        <a href="{{ route('regist') }}" class="btn btn-warning btn-sm">新規登録</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr id="product-{{$product->id}}">
                        <td class="align-middle">{{ $product->id }}</td>
                        <td class="align-middle">
                            <img class="img" src="{{ asset('storage/' . $product->img_path) }}" alt="画像">
                        </td>
                        <td class="align-middle">{{ $product->product_name }}</td>
                        <td class="align-middle">¥{{ number_format($product->price) }}</td>
                        <td class="align-middle">{{ $product->stock }}</td>
                        <td class="align-middle">{{ $product->company->company_name }}</td>
                        <td class="align-middle d-flex align-items-center gap-2 form-btn">
                            <form method='POST' action={{ route('detail', ['id' => $product->id]) }}>
                                @csrf
                                <input type='hidden' name='id' value="{{ $product->id }}">
                                <button type="submit" class="btn btn-info">詳細</button>
                            </form>
                            <form method='POST' action={{ route(
                                'delete', ['id' => $product->id]) }}>
                                @csrf
                                <input type='hidden' name='deleteData' value="{{ $product->id }}" data-product_id="{{$product->id}}" class="deleteData">
                                <button type="submit" data-product_id="{{$product->id}}" class="btn btn-danger" >削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="link">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
