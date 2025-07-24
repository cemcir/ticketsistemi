<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ITicketReponseDal;
use App\Models\TicketResponse;

class ElTicketResponseDal extends EloquentRepositoryBase implements ITicketReponseDal
{
    protected $model = TicketResponse::class;

}
