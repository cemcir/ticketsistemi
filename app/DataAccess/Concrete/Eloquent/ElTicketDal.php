<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ITicketDal;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ElTicketDal extends EloquentRepositoryBase implements ITicketDal
{
    protected $model=Ticket::class;

    public function GetAllByAdminId(int $adminId):Collection
    {
        return Ticket::select('ticketId AS ticketId',
                              'title AS title',
                              'description AS description',
                              'priority AS priority',
                              'status AS status')
                     ->where('adminId','=',$adminId)
                     ->get();
    }

}
