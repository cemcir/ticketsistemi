<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\ILogDal;
use App\Models\Log;

class ElLogDal extends EloquentRepositoryBase implements ILogDal
{
    protected $model=Log::class;
}
