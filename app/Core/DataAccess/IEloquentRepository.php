<?php

namespace App\Core\DataAccess;

interface IEloquentRepository
{
    public function Add(array $arr);
    public function LastInsertID(array $arr,string $id="id");
    public function GetAll(array $conditions=null);
    public function Update(array $arr,int $id,string $column);
    public function Delete(int $id,string $column);
    public function Get(array $conditions);
    public function WhereClause(array $conditions);
    public function TotalRecord(array $conditions);
    public function WhereIn(string $column,array $conditions);
    public function TotalPrice(string $column,array $conditions);
    public function TotalCount();
    public function AddRange(array $arr);
}
