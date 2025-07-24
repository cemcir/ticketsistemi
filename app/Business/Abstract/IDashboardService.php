<?php

namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;

interface IDashboardService
{
    public function Dashboard(int $offset=0,int $limit=10):IDataResult;

}
