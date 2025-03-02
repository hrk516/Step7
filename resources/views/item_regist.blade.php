@extends('layouts.item')

@section('title')
    商品新規登録画面
@endsection

@section('content')
    <div class="main">
        <div class="col-md-8 offset-md-3">
            <form method="POST" action={{ route('insert') }} enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="product_name" class="col-sm-2 col-form-label">商品名<span>*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}">
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
                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stock" class="col-sm-2 col-form-label">在庫数<span>*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
                        @error('stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label">コメント</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="comment" name="comment">{{ old('comment') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="img_path" class="col-sm-2 col-form-label">商品画像</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" id="img_path" name="img_path">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">新規登録</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">戻る</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
