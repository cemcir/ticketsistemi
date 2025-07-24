<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AdminAddRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'=>['required','string','max:100'],
            'password'=>['required','string','max:12'],
            'name'=>['required','string'],
            'surname'=>['required','string'],
            'email'=>['required','email'],
            'isActive'=>['required','integer'],
            'role'=>['required','string'],
            'phone' => [
                'required',
                'regex:/^(\+90|0)?5\d{9}$/'
            ],
            'image'=>'nullable|file|mimes:jpeg,png,jpg,gif|max:20480' // yani max:20 MB olabilir
        ];
    }
}
