<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ITicketResponseService;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessDataResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\ITicketReponseDal;

class TicketResponseManager implements ITicketResponseService
{
    private ITicketReponseDal $ticketReponseDal;

    public function __construct(ITicketReponseDal $ticketResponseDal) {
        $this->ticketReponseDal = $ticketResponseDal;
    }

    public function Add(array $ticketResponse): IResult
    {
        try {
            $this->ticketReponseDal->Add($ticketResponse);
            return new SuccessResult('Talebe Ait Mesaj Kaydedildi');
        }
        catch (\Exception $e) {
            return new ErrorResult('Talebe Ait Mesaj Kaydedilirken Hata Oluştu');
        }
    }

    public function GetAllByAdmin(int $adminId): IDataResult
    {
        $admins = $this->ticketReponseDal->GetAll([['adminId',$adminId]]);
        if(count($admins)>0) {
            return new SuccessDataResult($admins,'');
        }
        return new ErrorDataResult($admins,'');
    }

    public function GetAll(): IDataResult
    {
        return new SuccessDataResult($this->ticketReponseDal->GetAll(),'');
    }

}
