<?php
namespace App\Core\Validation;

use Illuminate\Support\Facades\Validator;

class Validate
{
    public static function ValidationMake(array $data,array $rules)
    {
        $validator = Validator::make($data,$rules);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        return null;
    }
}
