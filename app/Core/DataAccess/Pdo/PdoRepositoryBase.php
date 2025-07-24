<?php

namespace App\Core\DataAccess\Pdo;

use App\Core\DataAccess\IEloquentRepository;
use App\DataAccess\Concrete\Pdo\Database;
use PDO;

class PdoRepositoryBase implements IEloquentRepository
{
    protected $model;
    protected $db;

    public function __construct()
    {
        $this->db=Database::getInstance()->getConnection();
    }

    public function Add(array $arr): bool
    {
        $arr['created_at']=date('Y-m-d H:i:s');
        $columns=implode(',',array_keys($arr));
        $values=':'.implode(',:',array_keys($arr));

        $stmt=$this->db->prepare("INSERT INTO $this->model($columns) VALUES($values)");

        foreach ($arr as $key=>$value) {
            $type=$this->TypeControl($value);
            $stmt->bindValue(':'.$key,$value,$type);
        }
        return $stmt->execute();
    }

    public function Update(array $arr, int $id, string $column)
    {
        $updatedColumn="";
        if(isset($arr[$column])) {
            unset($arr[$column]);
        }

        $arr['updated_at'] = date('Y-m-d H:i:s');
        foreach ($arr as $key=>$value) {
            $updatedColumn=$updatedColumn."$key=:$key,";
        }
        $updatedColumn=rtrim($updatedColumn,',');

        $stmt=$this->db->prepare("UPDATE $this->model SET $updatedColumn WHERE $column=:$column");
        foreach ($arr as $key => $value) {
            $type=$this->TypeControl($value);
            $stmt->bindValue(":$key",$value,$type);
        }
        $stmt->bindParam(":$column",$id,PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function LastInsertID(array $arr): int
    {
        $arr['created_at']=date('Y-m-d H:i:s');
        $columns=implode(',',array_keys($arr));
        $values=':'.implode(',:',array_keys($arr));

        $stmt=$this->db->prepare("INSERT INTO $this->model($columns) VALUES($values)");
        foreach ($arr as $key=>$value) {
            $stmt->bindValue(":$key",$value);
        }
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function Delete(int $id,string $column)
    {
        $stmt=$this->db->prepare("UPDATE $this->model SET deleted_at='".date('Y-m-d H:i:s')."' WHERE $column=':'.$column");
        $stmt->bindParam(":$column",$entityId,PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function GetById(int $id,string $column)
    {
        $stmt=$this->db->prepare("SELECT * FROM $this->model WHERE $column=:$column AND deleted_at IS NULL");
        $stmt->bindParam(":$column",$id,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function GetAll(array $conditions = null)
    {
        $stmt=$this->db->prepare("SELECT * FROM $this->model");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function TypeControl($data)
    {
        $type=PDO::PARAM_NULL;
        if(is_bool($data))
            $type=PDO::PARAM_BOOL;
        else if(is_string($data))
            $type=PDO::PARAM_STR;
        else if(is_integer($data))
            $type=PDO::PARAM_INT;

        return $type;
    }

    public function WhereClause(array $conditions)
    {
        // TODO: Implement WhereClause() method.
    }

    public function TotalRecord(array $conditions)
    {
        // TODO: Implement TotalRecord() method.
    }

    public function WhereIn(string $column, array $conditions)
    {
        // TODO: Implement WhereIn() method.
    }

    public function TotalPrice(string $column, array $conditions)
    {
        // TODO: Implement TotalPrice() method.
    }

    public function TotalCount()
    {
        $stmt=$this->db->prepare("SELECT COUNT(*) AS totalRecord FROM $this->model");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['totalRecord'];
    }

    public function Get(array $conditions)
    {
        // TODO: Implement Get() method.
    }

}
