<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IResult;

interface ITicketResponseService
{
    public function Add(array $ticketResponse):IResult;
}
