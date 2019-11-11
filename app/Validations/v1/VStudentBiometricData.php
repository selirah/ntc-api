<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 3:33 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\OStudentBiometricData;


class VStudentBiometricData
{
    private $_biometric;

    public function __construct(OStudentBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    public function __validateBiometricInputs()
    {
        if (empty($this->_biometric->studentId)
            || empty($this->_biometric->templateKey)
            || empty($this->_biometric->fingerOne)
            || empty($this->_biometric->fingerTwo))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Fields: Student ID, Template Key, Finger One, Finger Two'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
