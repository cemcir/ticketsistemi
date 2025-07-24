<?php

namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AuthHelper extends BaseHelper {

    public function handleIKYSLogin(Request $request) {

        if(session()->has("token")){
            return response()->json([
                "status" => "error",
                "message" => "Zaten giriş yapmışsınız.",
                "session" => [
                    "displayName" => session("displayName"),
                    "adminId" => session("adminId"),
                    "loginTime" => session("loginTime"),
                ]
            ]);
        }

        if(config("app.env") === "local"){
            session()->put('token',"ENES-CEMCIR-TEST-TOKEN");
            session()->put('adminId',"5561");
            session()->put('displayName',"Muhammed Enes Cemcir");
            session()->put('role',"Personel");
            session()->put('image',"test.png");
            session()->put("loginTime", time());

            return response()->json([
                "status" => "success",
                "message" => "Local IKYS yetkilendirme başarıyla gerçekleştirildi.",
                "time" => time()
            ]);
        }
        //print_r($_REQUEST);
        session()->put('token',$request->post("token"));
        session()->put('adminId',$_REQUEST['adminId']);
        session()->put('displayName',$_REQUEST['displayName']);
        session()->put('role',$_REQUEST['role']);
        session()->put('image',$_REQUEST['fotograf']);
        session()->put("loginTime", time());

        return redirect()->to('/dashboard');
    }

}
