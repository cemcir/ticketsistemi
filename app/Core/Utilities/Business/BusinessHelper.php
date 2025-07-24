<?php

namespace App\Core\Utilities\Business;
use App\Exceptions\BusinessException;

class BusinessHelper {

    public static function Run(array $data) {
        try {
            BusinessRules::Run($data);
            return null;
        }
        catch(BusinessException $e) {
            return $e->getMessage();
        }
    }

}
