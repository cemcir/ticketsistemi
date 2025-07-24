<?php

namespace App\Http\Requests\Licence;

use App\Http\Requests\BaseRequest;

class LicenceUpdateRequest extends BaseRequest
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
            'licenceId'=>['required','integer'],
            'title'=>['required','string'],
            'description'=>['required','string'],
            'startDate'=>['required','date','date_format:Y-m-d'],
            'endDate'=>['nullable','date','date_format:Y-m-d'],
            'time'=>['nullable','string'],
            'from'=>['nullable','string'],
            'toWhom'=>['nullable','string'],
            'serialNumber'=>['nullable','string'],
            'mainCategoryId'=>['required','integer'],
            'customCategoryId'=>['required','integer']
        ];
    }
}
