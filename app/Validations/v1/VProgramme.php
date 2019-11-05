<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 10:24 AM
 */

namespace App\Validations\v1;

use App\Operations\v1\OProgramme;


class VProgramme
{
    private $_programme;

    public function __construct(OProgramme $programmeOperation)
    {
        $this->_programme = $programmeOperation;
    }

    public function __validateProgrammeInputs()
    {
        if (empty($this->_programme->programme))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: Programme'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
