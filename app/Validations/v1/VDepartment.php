<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 3:32 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\ODepartment;

class VDepartment
{
    private $_department;

    public function __construct(ODepartment $department)
    {
        $this->_department = $department;
    }

    public function __validateDepartmentInputs()
    {
        if (empty($this->_department->department) || empty($this->_department->hod) || empty($this->_department->programmeId))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: department name, head of department, programme'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
