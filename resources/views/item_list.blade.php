@extends('layouts.app')

@section('title')
    商品一覧画面
@endsection

@section('content')
    <div class="row">
        <form method='POST' action="{{ route('search') }}" class="d-flex align-items-center gap-2">
            @csrf
            <textarea class="form-control col-6" name="keyword" placeholder="検索キーワード"></textarea>
            <label for="price" class="col-sm-2 col-form-label">価格</label>
            <input type="number" name="low_price" value="">〜
            <input type="number" name="high_price" value="">
            <label for="price" class="col-sm-2 col-form-label">在庫</label>
            <input type="number" name="low_stock" value="">〜
            <input type="number" name="low_stock" value="">
            
            <select class="form-select col-4" name="company_id" aria-label="企業選択">
                <option value="" selected>選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            <input class="btn btn-primary" type="submit" value="検索" />
        </form>
    </div>

    <div class="main">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
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
                    <tr>
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
                            <form method='POST' action="{{ route('delete') }}">
                                @csrf
                                <input type='hidden' name='id' value="{{ $product->id }}">
                                <button type="submit" class="btn btn-danger" onclick='return confirm("削除します。よろしいですか？")'>削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="link">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
