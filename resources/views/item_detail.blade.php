@extends('layouts.item')

@section('title')
    商品情報詳細画面
@endsection

@section('content')
    <div class="mx-auto p-2" style="width: 50%;">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td>{{ $detail->id }}</td>
                </tr>
                <tr>
                    <th scope="row">商品画像</th>
                    <td>
                        <img class="img" src="{{ asset('storage/' . $detail->img_path) }}" alt="画像" width="100px" height="100px">
                    </td>
                </tr>
                <tr>
                    <th scope="row">商品名</th>
                    <td>{{ $detail->product_name }}</td>
                </tr>
                <tr>
                    <th scope="row">メーカー</th>
                    <td>{{ $detail->company->company_name }}</td>
                </tr>
                <tr>
                    <th scope="row">価格</th>
                    <td>¥{{ $detail->price }}</td>
                </tr>
                <tr>
                    <th scope="row">在庫数</th>
                    <td>{{ $detail->stock }}</td>
                </tr>
                <tr>
                    <th scope="row">コメント</th>
                    <td>{{ $detail->comment }}</td>
                </tr>
            </tbody>
        </table>
        <div>
            <a href="{{ route('edit',['id' => $detail->id]) }}" class="btn btn-warning">編集</a>
            <a href="{{ route('home') }}" class="btn btn-info">戻る</a>
        </div>
    </div>
@endsection
