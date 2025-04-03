<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    //
    public function purchase(Request $request){
        // 値の取得
        $product_id = $request->input('product_id');
        // 減少のための数 quantityが送られてなければ１を入れる
        $quantity = $request->input('quantity',1); 

        try{
            // DBでまとめて実行させる
            DB::transaction(function () use ($product_id, $quantity) {
                // 商品の検索　find→findOrFailだとnullの時勝手に404が飛ぶからエラーにならない（メッセは独自のは飛ばない）
                $product = Product::find($product_id);
                // 商品が存在しない、または在庫が不足している場合のバリデーションを行う
                if(!$product){
                    // 意図的にエラーを出す為にtryの中に記入 catchに飛んで$eにメッセージが入る
                    throw new \Exception('商品が見つかりません。');
                }
                if($product->stock < $quantity){
                    throw new \Exception('在庫が不足しています。');
                }
                // 在庫を減少させる
                $product -> stock -= $quantity;
                Sales::decrease($product);
                // Salesテーブルに商品IDと購入日時を記録する
                Sales::insertSales($product_id);
            });
            // 自販機にレスポンスを返す
            return response()->json(['message' => '購入しました。'], 200); 
        } catch (\Exception $e) {
            return response()->json(['error' => $e -> getMessage()], 400);
        }
    }
}
