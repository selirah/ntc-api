<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 9:39 AM
 */

namespace App\Validations\v1;

use App\Operations\v1\StaffPositionOperation;


class StaffPositionValidation
{
    private $_staffPosition;

    public function __construct(StaffPositionOperation $staffPositionOperation)
    {
        $this->_staffPosition = $staffPositionOperation;
    }

    public function __validateStaffPositionInputs()
    {
        if (empty($this->_staffPosition->position))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: Position name'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
