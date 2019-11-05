<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 11:07 AM
 */

namespace App\Validations\v1;

use App\Operations\v1\OSetting;


class VSetting
{
    private $_setting;

    public function __construct(OSetting $settingOperation)
    {
        $this->_setting = $settingOperation;
    }

    public function __validateSettingsInputs()
    {
        if (empty($this->_setting->academicYear)
            || empty($this->_setting->semester)
            || empty($this->_setting->feePercentageFreshers)
            || empty($this->_setting->feePercentageContinuing)
            || empty($this->_setting->registrationStartDate)
            || empty($this->_setting->registrationEndDate))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Fields: Academic Year, Semester, Fee Percentage for Freshers, Fee Percentage for Continuing Students, Registration Start Date, Registration End Date'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
