<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface ITicketService
{
    public function Add(array $ticket):IResult;
    public function Update(array $ticket):IResult;
    public function DeleteByAdmin(int $ticketId):IResult;
    public function DeleteByUser(int $ticketId):IResult;
    public function Get(int $ticketId):IDataResult;
    public function GetAll():IDataResult;
    public function GetListByUser(int $adminId):IDataResult;
    public function StatusUpdate(array $ticket):IResult;
}
