<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 11:21 AM
 */

namespace App\Validations\v1;

use App\Operations\v1\OFeeUnit;


class VFeeUnit
{
    private $_feeUnit;

    public function __construct(OFeeUnit $feeUnit)
    {
        $this->_feeUnit = $feeUnit;
    }

    public function __validateFeeUnitInputs()
    {
        if (empty($this->_feeUnit->unit))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: Fee Unit'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
