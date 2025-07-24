<?php

namespace App\Http\Controllers\Api;

use App\Business\Abstract\ITicketResponseService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketResponse\TicketResponseAddRequest;
use Illuminate\Http\Request;

class TicketResponseController extends Controller
{
    private ITicketResponseService $ticketResponseService;

    public function __construct(ITicketResponseService $ticketResponseService) {
        $this->ticketResponseService = $ticketResponseService;
    }

    public function Add(TicketResponseAddRequest $request):object
    {
        $admin = $request->get('user');
        $ticketResponse = $request->only(Keys::TicketResponseAdded());
        $ticketResponse['adminId'] = $admin['adminId'];

        $result = $this->ticketResponseService->Add($ticketResponse);
        if($result->Status()){
            return response()->json(['status'=>200,'data'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll(Request $request):object
    {
        $admins=[];
        $admin=$request->get('user');
        if($admin['role']=="user") {
            $admins = $this->ticketResponseService->GetAllByAdmin($admin['adminId'])->Data();
        }
        else {
            $admins = $this->ticketResponseService->GetAll()->Data();
        }

        return response()->json(['status'=>200,'data'=>$admins],200,[],JSON_UNESCAPED_UNICODE);
    }

}
