<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 1:03 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\OFee;


class VFee
{
    private $_fee;

    public function __construct(OFee $fee)
    {
        $this->_fee = $fee;
    }

    public function __validateFeesInputs()
    {
        if (empty($this->_fee->academicYear)
            || empty($this->_fee->programmeId)
            || empty($this->_fee->paymentMode)
            || empty($this->_fee->studentType)
            || empty($this->_fee->amount)
            || count($this->_fee->breakdown) == 0)
        {
            $response = [
                'error' =>true,
                'message' => 'Required Fields: Academic Year, Programme, Fee Payment Mode, Student Type, Amount, Breakdown'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
