<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;

interface ILicenceDal extends IEloquentRepository
{
    public function GetAllByLimit(int $offset,int $limit):Collection;
    public function Total():int;

    public function Search(string $search,int $offset,int $limit):Collection;
    public function SearchCount(string $search):int;
}
