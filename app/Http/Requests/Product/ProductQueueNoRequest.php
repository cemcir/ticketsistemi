<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductQueueNoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productBefore.productId' =>['required','integer','min:1'],
            'productBefore.queueNo'=>['required','integer','min:1'],
            'productAfter.productId'=>['required','integer','min:1'],
            'productAfter.queueNo'=>['required','integer','min:1']
        ];
    }
}
