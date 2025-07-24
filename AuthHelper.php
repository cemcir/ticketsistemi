<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class AuthHelper extends BaseHelper {

    public function handleIKYSLogin(Request $request){

        print_r($_REQUEST);
        /*
        session()->put('token',$_REQUEST['token']);
        session()->put('adminId',$_REQUEST['adminId']);
        session()->put('displayName',$_REQUEST['displayName']);
        session()->put('role',$_REQUEST['role']);
        */
        //return redirect()->to('/dashboard');
        exit();
    }

}
