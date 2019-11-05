<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/23/2019
 * Time: 12:36 PM
 */

namespace App\Validations\v1;


use App\Operations\v1\OCollege;

class VCollege
{
    private $_college;

    public function __construct(OCollege $collegeOperation)
    {
        $this->_college = $collegeOperation;
    }

    public function __validateCollegeInputs()
    {
        if (empty($this->_college->name) || empty($this->_college->senderId) ||
            empty($this->_college->region || empty($this->_college->town)))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Fields: Name, Sender ID, Region, Town'
            ];
            return ['response' => $response, 'code' => 400];
        }

        if (!empty($this->_college->email) && (!filter_var($this->_college->email, FILTER_VALIDATE_EMAIL)))
        {
            $response = [
                'error' =>true,
                'message' => 'Provide a valid email address in the format john@doe.com'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

}
