<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    // table名を記載することで紐付けられる
    protected $fillable = [
        'id',
        'company_name',
        'street_address',
        'representative_name'
    ];

    // Productsと紐付ける為に書く
    public function Products() {
        return $this->hasmany(Product::class, 'company_id');
    }

    // Companiesを取得（static=Cでnew（インスタンス化）しなくて済む）
    public static function getAllCompanies() {
        return self::orderBy('id', 'ASC')->get();
    }

    // 登録処理
    public static function getOrCreateCompanyId($companyId) {
        // 存在すればidが返ってくる（中身は配列）
        $company_id = self::where('id', $companyId)->first();
        // idが存在してなければ新規登録する
        if (empty( $company_id['id'] )) {
            return self::insertGetId(['company_name' => $company_id ['company_name']]);
        }
        // productに渡すcompany_idを返す
        return $company_id['id'];
    }

    // 検索処理 
    // public static function searchCompany($products) {
    //     if (isset($products['company_id'])) {
    //         return self::where('id', $products['company_id'])->first();
    //     }
    //     return null;
    // }
    // 検索処理 
    public static function searchCompany($products) {
        // コレクションが空でない場合
        if ($products->isNotEmpty()) {
            // 各商品からcompany_idを取得して対応する会社情報を検索
            $companyId = $products->pluck('company_id')->unique();  // 重複しないcompany_idを取得
            
            // 各company_idに対応する会社情報を取得
            return Company::whereIn('id', $companyId)->get();
        }

        return null;
    }
}
