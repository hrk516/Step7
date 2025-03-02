<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    // ここにバリデ書いていく
    public function rules() {
        return [
            'product_name' => 'required',
            'company_id'   => 'required',
            'price'        => 'required',
            'stock'        => 'required',
            'comment'      => 'nullable',
            'img_path'     => 'nullable'

        ];
    }

    public function messages() {
        return [
            'product_name.required' => '名前を入力してください。',
            'company_id.required' => 'メーカーを入力してください。',
            'price.required' => '金額を入力してください。',
            'stock.required' => '在庫数を入力してください。',
        ];
    }
}
