<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sales;

class SalesController extends Controller
{
    //
    public function purchase(Request $request){
        // 値の取得
        $product_id = $request->input('product_id');
        // 減少のための数 quantityが送られてなければ１を入れる
        $quantity = $request->input('quantity',1); 
        // 商品の検索
        $product = Product::find($product_id);
        // 商品が存在しない、または在庫が不足している場合のバリデーションを行う
        if(!$product){
            return response()->json(['message' => '商品が見つかりません。', 404]); 
        }
        if($product->stock < $quantity){
            return response()->json(['message' => '在庫が不足しています。', 422]); 
        }
        // 在庫を減少させる
        $product->stock -= $quantity;
        Sales::decrease($product);
        // Salesテーブルに商品IDと購入日時を記録する
        Sales::insertSales($product_id);
        // 自販機にレスポンスを返す
        return response()->json(['message' => '購入しました。'], 200); 
    }
}
