<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ITicketDal extends IEloquentRepository
{
    public function GetAllByAdminId(int $adminId):Collection;
}
