<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class QueueNoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoryBefore.categoryId' => ['integer','min:1'],
            'categoryBefore.queueNo' => ['integer','min:1'],
            'categoryAfter.categoryId' => ['integer','min:1'],
            'categoryAfter.queueNo' => ['integer','min:1'],
        ];
    }

}
