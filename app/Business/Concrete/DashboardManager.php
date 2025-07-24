<?php

namespace App\Business\Concrete;

use App\Business\Abstract\ICategoryService;
use App\Business\Abstract\IDashboardService;
use App\Business\Abstract\ILicenceService;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;

class DashboardManager implements IDashboardService
{
    private ILicenceService $licenceService;

    function __construct(ILicenceService $licenceService)
    {
        $this->licenceService = $licenceService;
    }

    public function Dashboard(int $offset=0,int $limit=10): IDataResult
    {
        $data=$this->licenceService->GetAllByLimit($offset,$limit)->Data();
        return new SuccessDataResult($data,'');
    }

}
