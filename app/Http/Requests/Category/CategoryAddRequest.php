<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

class CategoryAddRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoryName'=>['required','string']
        ];
    }
}
