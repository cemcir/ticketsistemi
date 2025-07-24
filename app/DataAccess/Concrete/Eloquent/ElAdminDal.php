<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IAdminDal;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ElAdminDal extends EloquentRepositoryBase implements IAdminDal
{
    protected $model=Admin::class;

    public function GetUserList(int $adminId):Collection
    {
        return Admin::select('adminId AS adminId',
                             'username AS username',
                             'email AS email',
                             'phone AS phone',
                             'role AS role',
                             'isActive AS isActive')
                     ->where('adminId','!=',$adminId)
                     ->get();
    }

    public function GetById(int $adminId)
    {
        return Admin::select('adminId AS adminId',
                             'username AS username',
                             'name AS name',
                             'surname AS surname',
                             'role AS role',
                             'isActive AS isActive',
                             'email AS email',
                             'phone AS phone',
                             'image AS image')
                    ->where('adminId',$adminId)
                    ->first();
    }

    public function GetByEmail(string $email, int $adminId = null):?Model
    {
        return Admin::where('email','=',$email)
                    ->where('adminId','!=',$adminId)
                    ->first();
    }

    public function GetByUserName(string $username, int $adminId = null):?Model
    {
        return Admin::where('username','=',$username)
                    ->where('adminId','!=',$adminId)
                    ->first();
    }

    public function GetByPhone(string $phone, int $adminId = null):?Model
    {
        return Admin::where('phone','=',$phone)
                    ->where('adminId','!=',$adminId)
                    ->first();
    }

    public function GetUserByPassword(string $password):?Model
    {
        return Admin::where('password', '=', $password)->first();
    }

    public function AdminList():Collection
    {
        return Admin::selectRaw("adminId AS adminId,
                                 name AS name,
                                 surname AS surname")
                    ->get();
    }

}
