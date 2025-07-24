<?php

namespace App\Http\Controllers\Web\Backend;

use App\Business\Abstract\ILicenceService;
use App\Business\Validation\Keys;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\Licence\LicenceAddRequest;
use App\Http\Requests\Licence\LicenceUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LicencesController extends Controller
{
    private ILicenceService $licenceService;

    public function __construct(ILicenceService $licenceService)
    {
        $this->licenceService = $licenceService;
    }

    public function Add(LicenceAddRequest $request):object
    {
        $category=[];
        $licence = $request->only(Keys::LicenceAdded());
        $licence['adminId']=1;
        if($request->has('mainCategoryName')) {
            $category['mainCategoryName']=$request->mainCategoryName;
            unset($licence['mainCategoryId']);
        }
        if($request->has('customCategoryName')) {
            $category['customCategoryName']=$request->customCategoryName;
            unset($licence['customCategoryId']);
        }
        if($request->has('forLife') && $request->forLife==1) {
            $licence['endDate']="3999-12-31";
        }

        $result = $this->licenceService->Add($licence,$category);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(LicenceUpdateRequest $request):object
    {
        $category=[];
        $licence = $request->only(Keys::LicenceUpdated());
        $licence['adminId']=1;
        if($request->has('mainCategoryName')) {
            $category['mainCategoryName']=$request->mainCategoryName;
        }
        if($request->has('customCategoryName')) {
            $category['customCategoryName']=$request->customCategoryName;
        }
        if($request->has('forLife') && $request->forLife==1) {
            $licence['endDate']="3999-12-31";
        }

        $result = $this->licenceService->Update($licence,$category);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll():View
    {
        $data = $this->licenceService->GetAllByLimit(0,10)->Data();
        return View('backend.licence.getall',compact('data'));
    }

    public function Search(Request $request):object
    {
        $search = $request->has('search') ? (string)$request->search : "";
        $offset = $request->has('offset') ? (int)$request->offset : 0;
        $limit = $request->has('limit') ? (int)$request->limit : 10;

        $result = $this->licenceService->Search($search, $offset, $limit);

        if ($result->Status()) {
            return response()->json(['status' => 200, 'data' => $result->Data()], 200, [], JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status' => 404, 'data' => $result->Data()], 404, [], JSON_UNESCAPED_UNICODE);
    }

    public function Cancel(Request $request):object
    {
        $result = $this->licenceService->Cancel($request->licenceId);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function AddPage():View
    {
        $data = $this->licenceService->CategoryListOfLicence()->Data();
        return view('backend.licence.add',compact('data'));
    }

    public function UpdatePage(Request $request):View
    {
        $data = $this->licenceService->CategoryListOfLicence()->Data();
        $data['licence'] = $this->licenceService->Get($request->licenceId)->Data();

        return view('backend.licence.update',compact('data'));
    }

}
