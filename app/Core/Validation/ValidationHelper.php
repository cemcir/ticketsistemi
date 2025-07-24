<?php
namespace App\Core\Validation;

use Illuminate\Http\Request;

class ValidationHelper {

    public static function Run(Request $request,array $keys,array $rules,$file='image') {
        $data = $request->only($keys);
        if($request->hasFile($file)) {
            $data['image']=$request->file($file);
        }
        $validator = Validate::ValidationMake($data,$rules);
        if($validator != null) {
            return response()->json(['status'=>422,'msg'=>$validator],422,[],JSON_UNESCAPED_UNICODE);
        }
        return null;
    }

}
