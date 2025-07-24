<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\Abstract\IAdminService;
use App\Business\Validation\Keys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminsController extends Controller
{
    private IAdminService $adminService;

    public function __construct(IAdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function Login(Request $request) {
        $result=$this->adminService->Login($request->username,$request->password);
        if($result->Status()) {
            Session::put('adminId',$result->Data()['adminId']);
            Session::put('token',$result->Data()['token']);
            Session::put('displayName',$result->Data()['name']." ".$result->Data()['surname']);
            Session::put('role',$result->Data()['role']);
            Session::put('image',$result->Data()['image']);

            return redirect()->route('dashboard');
        }
        return view('backend.login.login');
    }

    public function LoginPage() {

        return view('backend.login.login');
    }

    public function AddPage() {

        return view('backend.admin.add');
    }

    public function UpdatePage(Request $request) {

        $admin=$this->adminService->Get($request->adminId)->Data();
        $admin['roles']=['admin'=>'Yönetici','user'=>'Çalışan'];
        $admin['active']=[0,1];

        return view('backend.admin.update',compact('admin'));
    }

    public function Logout() {

        Auth::logout(); // Oturumu sonlandır
        session()->invalidate(); // Tüm oturumları sıfırla
        session()->regenerateToken(); // CSRF token'ını yenile
        session()->flush(); // Oturum verilerini temizle
        session()->regenerate(); // Yeni bir oturum başlat (ID yenile)

        return redirect()->route('loginForm');
    }

    public function Profil(Request $request) {

        $adminId=$request->get('admin')['adminId'];
        $admin=$this->adminService->Get($adminId)->Data();

        return view('backend.admin.profil',compact('admin'));
    }

    public function ProfilUpdate(Request $request) {

        $admin=$request->only(Keys::ProfilUpdate());
        $admin['image']=null;
        if($request->hasFile('image')) {
            $admin['image']=$request->file('image');
        }

        $result=$this->adminService->ProfilUpdate($admin,$admin['adminId']);
        if($result->Status()) {
            $this->Logout();
            return response()->json(['status'=>200,'data'=>$result->Data(),'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'data'=>$result->Data(),'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function PasswordUpdate(Request $request):object {

        $admin=$request->only(Keys::UserPasswordUpdate());
        $result=$this->adminService->PasswordUpdate($admin);
        if($result->Status()) {
            $this->Logout();// session ı öldür
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll(Request $request) {

        $adminId=$request->get('admin')['adminId'];
        $admins=$this->adminService->GetUserList($adminId)->Data();

        return view('backend.admin.getall',compact('admins'));
    }

    public function Add(Request $request):object {

        $admin=$request->only(Keys::AdminAdd());
        $admin['image']=null;
        if($request->hasFile('image')) {
            $admin['image']=$request->file('image');
        }

        $result=$this->adminService->Add($admin);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(Request $request):object {

        $adminUpdate=$request->only(Keys::AdminUpdate());
        $adminUpdate['image']=null;
        if($request->hasFile('image')) {
            $adminUpdate['image']=$request->file('image');
        }

        $result=$this->adminService->Update($adminUpdate,$request->adminId);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data(),'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'data'=>$result->Data(),'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Delete(Request $request):object {

        $result=$this->adminService->Delete($request->adminId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

}
