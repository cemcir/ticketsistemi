<?php

namespace App\Http\Controllers\Web\Backend;

use App\Business\Abstract\IMainCategoryService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainCategoriesController extends Controller
{
    private IMainCategoryService $mainCategoryService;

    public function __construct(IMainCategoryService $mainCategoryService){
         $this->mainCategoryService = $mainCategoryService;
    }

    public function Add(Request $request):object
    {
        $mainCategory = $request->only(Keys::MainCategoryAdded());
        $result = $this->mainCategoryService->Add($mainCategory);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(Request $request):object
    {
        $mainCategory = $request->only(Keys::MainCategoryUpdated());
        $result = $this->mainCategoryService->Update($mainCategory);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll():View
    {
        $data = $this->mainCategoryService->GetAll()->Data();
        return view('backend.maincategory.getall',compact('data'));
    }

    public function Delete(Request $request):object
    {
        $result = $this->mainCategoryService->Delete($request->mainCategoryId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Search(Request $request):object
    {
        $search = $request->has('search') ? (string) $request->query('search') : '';
        $result = $this->mainCategoryService->Search($search);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>404,'data'=>$result->Data()],404,[],JSON_UNESCAPED_UNICODE);
    }

    public function AddPage():View
    {
        return View('backend.maincategory.add');
    }

    public function UpdatePage(Request $request):View
    {
        $data = $this->mainCategoryService->Get($request->mainCategoryId)->Data();
        return View('backend.maincategory.update',compact('data'));
    }

}
