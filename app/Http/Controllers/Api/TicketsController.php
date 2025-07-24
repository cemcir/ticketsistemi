<?php

namespace App\Http\Controllers\Api;

use App\Business\Abstract\ITicketService;
use App\Business\Validation\Keys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketAddRequest;
use App\Http\Requests\Ticket\TicketStatusRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    private ITicketService $ticketService;

    function __construct(ITicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function Add(TicketAddRequest $request):object
    {
        $admin = $request->get("user");
        $ticket = $request->only(Keys::TicketAdded());
        $ticket['adminId']=$admin['adminId'];

        $result = $this->ticketService->Add($ticket);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Update(TicketUpdateRequest $request):object
    {
        $ticket = $request->only(Keys::TicketUpdated());
        $result = $this->ticketService->Update($ticket);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function GetAll(Request $request):object
    {
        $tickets=[];
        $admin = $request->get('user');
        if($admin['role']=='user') {
            $tickets = $this->ticketService->GetListByUser($admin['adminId'])->Data();
        }
        $tickets = $this->ticketService->GetAll()->Data();
        return response()->json(['status'=>200,'data'=>$tickets],200,[],JSON_UNESCAPED_UNICODE);
    }

    public function Delete(Request $request)
    {
        $admin = $request->get('user');
        if($admin['role']=="admin") {
            $result = $this->ticketService->DeleteByAdmin($request->ticketId);
        }
        else {
            $result = $this->ticketService->DeleteByUser($request->ticketId);
        }
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

    public function Get(Request $request):object
    {
        if($request->query('ticketId') && $request->query('ticketId')!=null) {
            $ticket =$this->ticketService->Get($request->query('ticketId'))->Data();
            if($ticket) {
                return response()->json(['status'=>200,'data'=>$ticket],200,[],JSON_UNESCAPED_UNICODE);
            }
        }
        return response()->json(['status'=>404,'data'=>[]],404,[],JSON_UNESCAPED_UNICODE);
    }

    public function StatusUpdate(TicketStatusRequest $request):object
    {
        $ticketStatus = $request->only(Keys::StatusUpdate());
        $result = $this->ticketService->StatusUpdate($ticketStatus);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200,[],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['status'=>400,'msg'=>$result->Message()],400,[],JSON_UNESCAPED_UNICODE);
    }

}
