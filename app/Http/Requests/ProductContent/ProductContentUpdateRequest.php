<?php

namespace App\Http\Requests\ProductContent;

use App\Http\Requests\BaseRequest;

class ProductContentUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId'=>['required','numeric','min:1'],
            'productContent'=>['nullable','array'],
            'productContent.*.content'=>['required','string'],
            'productContent.*.price'=>['decimal:10,2','min:0']
        ];
    }
}
