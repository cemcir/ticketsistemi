<?php

namespace App\Http\Controllers\Web\Backend;

use App\Business\Abstract\ICustomCategoryService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomCategoriesController extends Controller
{
    private ICustomCategoryService $customCategoryService;

    public function __construct(ICustomCategoryService $customCategoryService) {
        $this->customCategoryService = $customCategoryService;
    }

    public function Add(Request $request):object
    {
        $customCategory = $request->only(Keys::CustomCategoryAdd());
        $result = $this->customCategoryService->Add($customCategory);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(Request $request):object
    {
        $customCategory = $request->only(Keys::CustomCategoryUpdate());
        $result = $this->customCategoryService->Update($customCategory);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Delete(Request $request):object
    {
        $result = $this->customCategoryService->Delete($request->customCategoryId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll():View
    {
        $data = $this->customCategoryService->GetAll()->Data();
        return view('backend.customcategory.getall',compact('data'));
    }

    public function Search(Request $request):object
    {
        $search = $request->has('search') ? (string) $request->query('search') : '';

        $result = $this->customCategoryService->Search($search);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>404,'data'=>$result->Data()],404,[],JSON_UNESCAPED_UNICODE);
    }

    public function AddPage():View
    {
        return view('backend.customcategory.add');
    }

    public function UpdatePage(Request $request):View
    {
        $data = $this->customCategoryService->Get($request->customCategoryId)->Data();
        return view('backend.customcategory.update',compact('data'));
    }

}
