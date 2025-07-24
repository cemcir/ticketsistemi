<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface ITicketResponseService
{
    public function Add(array $ticketResponse):IResult;
    public function GetAllByAdmin(int $adminId):IDataResult;
    public function GetAll():IDataResult;
}
