<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId'=>['required','numeric'],
            'productName'=>['required','string'],
            'price'=>['decimal:10,2','min:0'],
            'categoryId'=>['required','numeric'],
            'image'=>['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'productContent'=>['nullable','array'],
            'productContent.*.price'=>['required','decimal:10,2','min:0'],
            'productContent.*.content'=>['required','string']
        ];
    }
}
