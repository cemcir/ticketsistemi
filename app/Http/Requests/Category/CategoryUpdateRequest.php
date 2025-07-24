<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoryId'=>['required','integer'],
            'categoryName'=>['required','string'],
            'image'=>['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048']
        ];
    }
}
