<?php

namespace App\Http\Requests\product;

use App\Http\Requests\BaseRequest;

class ProductAddRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productName'=>['required','string'],
            'price' => ['required','regex:/^\d{1,8}(\.\d{1,2})?$/','min:0'],
            'image'=>['nullable','image','mimes:jpeg,png,jpg,gif,svg,jfif','max:2048'],
            'categoryId'=>['required','numeric'],
            'productContent'=>['nullable','array'],
            'productContent.*.price'=> ['regex:/^\d{1,8}(\.\d{1,2})?$/','min:0'],
            'productContent.*.content'=>['string']
        ];
    }

}
