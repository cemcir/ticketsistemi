<?php

namespace App\DataAccess\Concrete\DbQuery;

use Illuminate\Support\Facades\DB;

class DqSalonDal
{
    public function GetAll():object
    {
        return DB::table('salons')->get();
    }
}
