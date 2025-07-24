<?php

namespace App\DataAccess\Abstract;

use App\Core\DataAccess\IEloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface IAdminDal extends IEloquentRepository
{
    public function GetUserList(int $adminId):Collection;
    public function GetByEmail(string $email,int $adminId=null):?Model; // gönderilen eposta adresi başka kullnıcı tarafından kullanılıyor mu
    public function GetByUserName(string $username,int $adminId=null):?Model; // gönderilen kullanıcı sistemde daha önce kullanıldı mı ?
    public function GetByPhone(string $phone,int $adminId=null):?Model;
    public function GetById(int $adminId);
    public function GetUserByPassword(string $password):?Model;
    public function AdminList():Collection;
}
