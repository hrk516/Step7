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
}
