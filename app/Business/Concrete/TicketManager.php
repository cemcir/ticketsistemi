<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ITicketService;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\ITicketDal;

class TicketManager implements ITicketService
{
    private ITicketDal $ticketDal;

    function __construct(ITicketDal $ticketDal)
    {
        $this->ticketDal=$ticketDal;
    }

    public function Add(array $ticket): IResult
    {
        try {
            $this->ticketDal->Add($ticket);
            return new SuccessResult('Talep Başarıyla Oluşturuldu');
        }
        catch (\Exception $e) {
            return new ErrorResult($e->getMessage());
        }
    }

    public function Update(array $ticket): IResult
    {
        if($this->ticketDal->Get(['ticketId','=',$ticket['ticketId']])) {
            if($this->ticketDal->Update($ticket,$ticket['ticketId'],'ticketId')) {
                return new SuccessResult('Talep Kaydı Başarıyla Güncellendi');
            }
            return new ErrorResult('Talep Kaydı Güncellenirken Hata Oluştu');
        }
        return new ErrorResult('Talep Kaydı Bulunamadı');
    }

    public function DeleteByUser(int $ticketId): IResult
    {
        if($this->ticketDal->Get([['ticketId','=',$ticketId]])) {
            if($this->ticketDal->Get(['status','=','open'])) {
                if ($this->ticketDal->Delete($ticketId, 'ticketId')) {
                    return new SuccessResult('Talep Kaydı Başarıyla Silindi');
                }
                return new ErrorResult('Durumu Açık Olmayan Talebi Silemezsiniz');
            }
        }
        return new ErrorResult('Talep Kaydı Bulunamadı');
    }

    public function Get(int $ticketId): IDataResult
    {
        $admin = $this->ticketDal->Get([['ticketId','=',$ticketId]]);
        if($admin) {
            return new SuccessDataResult($admin,'');
        }
        return new ErrorDataResult($admin,'');
    }

    public function GetAll(): IDataResult
    {
        return new SuccessDataResult($this->ticketDal->getAll(),'');
    }

    public function DeleteByAdmin(int $ticketId): IResult
    {
        if($this->ticketDal->Get([['ticketId','=',$ticketId]])) {
            if($this->ticketDal->Delete($ticketId,'ticketId')) {
                return new SuccessResult('Talep Kaydı Başarıyla Silindi');
            }
            return new SuccessResult('Talep Kaydı Silinirken Hata Oluştu');
        }
        return new ErrorResult('Talep Kaydı Bulunamadı');
    }

    public function GetListByUser(int $adminId): IDataResult
    {
        return new SuccessDataResult($this->ticketDal->GetAll([['adminId','=',$adminId]]),'');
    }

    public function StatusUpdate(array $ticket): IResult
    {
        try {
            if ($this->ticketDal->Get([['ticketId','=',$ticket['ticketId']]])) {
                if ($this->ticketDal->Update(['status' => $ticket['status']], $ticket['ticketId'], 'ticketId')) {
                    return new SuccessResult('Talep Kaydı Durumu Başarıyla Güncellendi');
                }
            }
            return new ErrorResult('Talep Kaydı Bulunamadı');
        }
        catch (\Exception $e) {
            return new ErrorResult($e->getMessage());
        }
    }

}
