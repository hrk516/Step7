<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function createSales($id) {
        // product_idとして$idを渡して新しいSalesを作成
        return self::create([
            'product_id' => $id,
        ]);
    }
}
