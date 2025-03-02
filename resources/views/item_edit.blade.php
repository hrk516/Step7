@extends('layouts.item')

@section('title')
    商品情報編集画面
@endsection

@section('content')
    <div class="main">
        <div class="col-md-6 offset-md-3">
            <form method="POST" enctype="multipart/form-data" action={{ route('update', ['id' => $id]) }}>
                @csrf
                <div class="form-group row">
                    <label for="product_name" class="col-sm-2 col-form-label">ID</label>
                    <div class="col-sm-10">
                        {{ $id }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_name" class="col-sm-2 col-form-label">商品名<span>*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $item['product_name'] }}">
                        @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="company_name" class="col-sm-2 col-form-label">メーカー名<span>*</span></label>
                    <div class="col-sm-10">
                        <select id="company_name" class="form-control" name="company_id">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        @error('company_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-2 col-form-label">価格<span>*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price" name="price" value="{{ $item['price'] }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stock" class="col-sm-2 col-form-label">在庫数<span>*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stock" name="stock" value="{{ $item['stock'] }}">
                        @error('stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label">コメント</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="comment" name="comment">{{ $item['comment'] }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="img_path" class="col-sm-2 col-form-label">商品画像</label>
                    <div class="col-sm-10">
                        <img class="img" src="{{ asset('storage/' . $item->img_path) }}" alt="画像">
                        <input type="file" class="form-control-file file" id="img_path" name="img_path">
                        <input type="hidden" name="existing_img_path" value="{{ $item['img_path'] }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-warning">更新</button>
                        <a href="{{ route('detail',['id' => $item->id]) }}" class="btn btn-info">戻る</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
