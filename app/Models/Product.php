<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // $fillableはinsertやcreate(saveは手動でいける)をする為にカラムを書いていく
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    // companyと紐付ける為に書く
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // productを取得（static=Cでnew（インスタンス化）しなくて済む）
    public static function getAllProducts() {
        return self::orderBy('id', 'ASC')->paginate(5);
    }

    // 新規登録処理
    public static function createProduct($data) {
        return self::create($data);
    }

    // 詳細画面表示用 一致するidのモノを取得
    public static function getProduct($id) {
        return self::find($id);
    }

    // 更新処理 update/deleteはインスタンスに対して実行する
    public static function updateProduct($id, $update_data) {
        $product_data = self::find($id);
        if ($product_data) {
            $product_data -> update($update_data);
            return $product_data;
        }
        return null;
    }

    // 削除処理 update/deleteはインスタンスに対して実行する
    public static function deleteProduct($id) {
        $delete_data = self::find($id);
        if ($delete_data) {
            $delete_data -> delete($delete_data);
            return $delete_data;
        }
        return null;
    }

    // 検索処理 
    public static function searchProduct($keyword) {
        if ($keyword && isset($keyword['keyword']) && isset($keyword['company_id'])) {
            $searched_data = self::where('product_name','like',"%{$keyword['keyword']}%")
            ->where('company_id', $keyword['company_id'])
            ->paginate(5);
            return $searched_data;
        }
        return self::orderBy('id', 'ASC')->paginate(5);
    }
}