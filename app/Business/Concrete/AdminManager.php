<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IAdminService;
use App\Business\Constants\Abstract\IMessage;
use App\Core\Utilities\Business\BusinessHelper;
use App\Core\Utilities\FileOperations\Upload;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\Core\Utilities\Security\Hashing\HashingHelper;
use App\Core\Utilities\Security\JWT\JwtHelper;
use App\DataAccess\Abstract\IAdminDal;

class AdminManager implements IAdminService
{
    private IAdminDal $adminDal;
    private IMessage $message;

    public function __construct(IAdminDal $adminDal,IMessage $message)
    {
        $this->adminDal = $adminDal;
        $this->message = $message;
    }

    public function Login(string $username,string $password): IDataResult
    {
        $admin=$this->adminDal->Get([['username','=',$username],['isActive','=',1]]);
        if($admin) {
            $admin=$admin->toArray();
            if(HashingHelper::PasswordVerify($password,$admin['password'])) {
                $admin['token']=JwtHelper::CreateToken($admin);
                $this->adminDal->Update(['lastLoginDate'=>date('Y-m-d H:i:s')],$admin['adminId'],'adminId');
                return new SuccessDataResult($admin,'');
            }
        }
        return new ErrorDataResult([],'');
    }

    public function Add(array $admin):IResult
    {
        $result=BusinessHelper::Run([$this->CheckIfUserEmailAlreadyExist($admin['email']),
                                     $this->CheckIfUserNameAlreadyExist($admin['username']),
                                     $this->CheckIfUserPhoneAlreadyExist($admin['phone'])]);
        if($result!=null) {
            return new ErrorResult($result);
        }

       if($admin['image']!=null) {
            $admin['image']=Upload::ImageUpload($admin['image'],'uploads/images/user');
        }

        $admin['password']=HashingHelper::PasswordHash($admin['password']);
        if($this->adminDal->Add($admin)) {

            return new SuccessResult($this->message->adminAdded());
        }
        return new ErrorResult($this->message->AdminNotAdded());
    }

    public function ProfilUpdate(array $adminUpdate,int $adminId): IDataResult
    {
        $admin=$this->adminDal->Get([['adminId','=',$adminId]]);
        if(!$admin) {
            return new ErrorDataResult([],$this->message->AdminNotFound());
        }

        $result=BusinessHelper::Run([$this->CheckIfUserEmailAlreadyExist($adminUpdate['email'],$adminId),
                                     $this->CheckIfUserPhoneAlreadyExist($adminUpdate['phone'],$adminId)]);
        if($result!=null) {
            return new ErrorDataResult([],$result);
        }

        if($adminUpdate['image']!=null) {
            $adminUpdate['image']=Upload::ImageUpload($adminUpdate['image'],'uploads/images/user');
            if(file_exists($admin->image)) {
                unlink($admin->image);
            }
        }
        else {
            $adminUpdate['image']=$admin->image;
        }

        if($this->adminDal->Update($adminUpdate,$adminId,'adminId')) {
            return new SuccessDataResult(['image'=>$adminUpdate['image']],$this->message->AdminUpdated());
        }
        return new ErrorDataResult([],$this->message->AdminNotUpdated());
    }

    public function PasswordUpdate(array $passwordUpdate): IResult
    {
        $admin=$this->adminDal->Get([['adminId','=',$passwordUpdate['adminId']]]);
        if(!$admin) {
            return new ErrorResult($this->message->AdminNotFound());
        }

        $result=BusinessHelper::Run([$this->CheckIfOldPasswordExist($admin['password'],$passwordUpdate['oldPassword'])]);
        if($result!=null) {
            return new ErrorResult($result);
        }

        $password=HashingHelper::PasswordHash($passwordUpdate['password']);
        if($this->adminDal->Update(['password'=>$password],$admin['adminId'],'adminId')) {
            return new SuccessResult($this->message->AdminPasswordUpdate());
        }
        return new ErrorResult($this->message->AdminPasswordNotUpdate());
    }

    public function GetUserList(int $adminId): IDataResult
    {
        $admins=$this->adminDal->GetUserList($adminId);
        if(count($admins)>0) {
            return new SuccessDataResult($admins,'');
        }
        return new ErrorDataResult($admins,'');
    }

    public function Update(array $adminUpdate,int $adminId):IDataResult
    {
        $admin=$this->adminDal->Get([['adminId','=',$adminId]]);
        if($admin) {
            $result=BusinessHelper::Run([$this->CheckIfUserEmailAlreadyExist($adminUpdate['email'],$adminId),
                                         $this->CheckIfUserNameAlreadyExist($adminUpdate['username'],$adminId),
                                         $this->CheckIfUserPhoneAlreadyExist($adminUpdate['phone'],$adminId)
                                        ]);
            if($result!=null) {
                return new ErrorDataResult([],$result);
            }

            if ($adminUpdate['image'] != null) {
                $adminUpdate['image'] = Upload::ImageUpload($adminUpdate['image'],'uploads/images/user');
                if (file_exists($admin['image'])) {
                    unlink($admin['image']);
                }
            }
            else {
                $adminUpdate['image'] = $admin['image'];
            }
            if($this->adminDal->Update($adminUpdate,$adminUpdate['adminId'],'adminId')) {
                return new SuccessDataResult(['image'=>$adminUpdate['image']],$this->message->AdminUpdated());
            }
            return new SuccessDataResult(['image'=>$adminUpdate['image']],$this->message->AdminNotUpdated());
        }
        return new ErrorDataResult(['image'=>$adminUpdate['image']],$this->message->AdminNotFound());
    }

    public function Get(int $adminId): IDataResult
    {
        $admin=$this->adminDal->GetById($adminId);
        if($admin) {
            return new SuccessDataResult($admin,'');
        }
        return new ErrorDataResult($admin,'');
    }

    public function Delete(int $adminId):IResult
    {
        $admin = $this->adminDal->Get([['adminId','=',$adminId]]);
        if($admin!=null) {
            $result=BusinessHelper::Run([$this->CheckIfUserAlreadyExistForRezervation($adminId),
                                         $this->CheckIfUserAlreadyExistForPayment($adminId),
                                         $this->CheckIfUserExistForPaymentCustomer($adminId)]);

            if($result!=null) {
                return new ErrorResult($result);
            }

            if($this->adminDal->Delete($adminId,'adminId')) {
                return new SuccessResult($this->message->AdminDeleted());
            }
            return new ErrorResult($this->message->AdminNotDeleted());
        }
        return new ErrorResult($this->message->AdminNotFound());
    }

    private function CheckIfOldPasswordExist(string $hashPassword,string $oldPassword):IResult { // gönderilen eski şifre geçerli mi kontrol et

        if(!HashingHelper::PasswordVerify($oldPassword,$hashPassword)) {
            return new ErrorResult($this->message->OldPasswordFalse());
        }
        return new SuccessResult('');
    }

    private function CheckIfUserPhoneAlreadyExist(string $phone,int $adminId=null):IResult
    {
        if($this->adminDal->GetByPhone($phone,$adminId)) {
            return new ErrorResult($this->message->AdminPhoneAlreadyExist());
        }
        return new SuccessResult('');
    }

    private function CheckIfUserNameAlreadyExist(string $username,int $adminId=null):IResult
    {
        if($this->adminDal->GetByUserName($username,$adminId)) {
            return new ErrorResult($this->message->AdminNameAlreadyExist());
        }
        return new SuccessResult('');
    }

    private function CheckIfUserEmailAlreadyExist(string $email,int $adminId=null):IResult
    {
        if($this->adminDal->GetByEmail($email,$adminId)) {
            return new ErrorResult($this->message->AdminEmailAlreadyExist());
        }
        return new SuccessResult('');
    }

    public function GetAll():IDataResult
    {
        return new SuccessDataResult($this->adminDal->AdminList()->toArray(),'');
    }

}
