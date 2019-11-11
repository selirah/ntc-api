<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 1:46 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\OStaffBiometricData;


class VStaffBiometricData
{
    private $_biometric;

    public function __construct(OStaffBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    public function __validateBiometricInputs()
    {
        if (empty($this->_biometric->staffId)
            || empty($this->_biometric->templateKey)
            || empty($this->_biometric->fingerOne)
            || empty($this->_biometric->fingerTwo))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Fields: Staff ID, Template Key, Finger One, Finger Two'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
