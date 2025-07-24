<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ITicketResponseService;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\ITicketDal;
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

}
