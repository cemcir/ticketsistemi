<?php

namespace App\Core\DataAccess\Eloquent;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRepositoryBase implements IEloquentRepository
{
    protected $model;

    public function GetAll(array $conditions=null): Collection
    {
        if($conditions!=null) {
            return $this->model::where($conditions)->get();
        }
        return $this->model::all();
    }

    public function Add(array $arr): Model
    {
        return $this->model::create($arr);
    }

    public function Update(array $arr,int $id,string $column): int
    {
        return $this->model::where($column,$id)->update($arr);
    }

    public function Delete(int $id,string $column): int
    {
        return $this->model::where($column,$id)->delete();
    }

    public function Get(array $conditions): ?Model
    {
        return $this->model::where($conditions)->first();
    }

    public function WhereClause(array $conditions): ?Model
    {
//        $conditions=[
//            ['salonTurID','=',1],
//            ['turAdi','=','deneme']
//        ];

        //return $this->model::where($conditions[0][0],$conditions[0][2])->orWhere($conditions[1][0],$conditions[1][2])->first();

        return $this->model::where($conditions)->first();
    }

    public function LastInsertID(array $arr,string $id="id")
    {
        return $this->model::create($arr)->$id;
    }

    public function TotalRecord(array $conditions): int
    {
        return $this->model::where($conditions)->count();
    }

    public function WhereIn(string $column,array $conditions)
    {
        return $this->model::whereIn($column,$conditions)->get();
    }
    public function TotalPrice(string $column,array $conditions)
    {
        return $this->model::where($conditions)->sum($column);
    }
    public function TotalCount():int
    {
        return $this->model::count();
    }

    public function AddRange(array $arr)
    {
        foreach ($arr as $value) {
            $this->model::create($value);
        }
    }
}
