<?php

namespace App\Http\Controllers\Web\Backend;

use App\Business\Abstract\ICategoryService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryAddRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /*
    private ICategoryService $categoryService;

    public function __construct(ICategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function Add(CategoryAddRequest $request):object
    {
        $category = $request->only(Keys::CategoryAdd());

        $result = $this->categoryService->Add($category);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Delete(Request $request):object
    {
        $result = $this->categoryService->Delete($request->categoryId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(CategoryUpdateRequest $request):object
    {
        $category = $request->only(Keys::CategoryUpdate());
        $result = $this->categoryService->Update($category);
        if($result->Status()) {
            return response()->json(['status'=>200,'data'=>$result->Data(),'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'data'=>$result->Data(),'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll():View
    {
        $data = $this->categoryService->GetAll()->Data();
        return view('backend.category.getall',compact('data'));
    }

    public function UpdatePage(Request $request):View
    {
        $data = $this->categoryService->Get($request->categoryId)->Data();
        return View('backend.category.update',compact('data'));
    }

    public function AddPage():View
    {
        $data['parentCategories'] = $this->categoryService->ParentCategories()->Data();
        return View('backend.category.add',compact('data'));
    }
    */
}
