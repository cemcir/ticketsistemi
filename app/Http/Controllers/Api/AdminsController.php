<?php

namespace App\Http\Controllers\Api;

use App\Business\Abstract\IAdminService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAddRequest;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    private IAdminService $adminService;

    public function __construct(IAdminService $adminService) {
        $this->adminService = $adminService;
    }

    public function Login(Request $request):object
    {
        $result = $this->adminService->login($request->username,$request->password);

        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()['token']],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>401,'data'=>null],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Add(AdminAddRequest $request):object
    {
        $admin = $request->only(Keys::AdminAdd());
        $admin['image']=null;
        if($request->hasFile('image')) {
            $admin['image']=$request->file('image');
        }
        $result = $this->adminService->add($admin);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>401,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

}
