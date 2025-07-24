<?php
namespace App\Business\Abstract;

use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;

interface IAdminService
{
    public function Add(array $admin):IResult;
    public function Get(int $adminId):IDataResult;
    public function Update(array $adminUpdate,int $adminId):IDataResult;
    public function Delete(int $adminId):IResult;
    public function Login(string $username,string $password):IDataResult;
    public function PasswordUpdate(array $passwordUpdate):IResult;
    public function GetUserList(int $adminId):IDataResult;
    public function ProfilUpdate(array $adminUpdate,int $adminId):IDataResult;
    public function GetAll():IDataResult;
}
