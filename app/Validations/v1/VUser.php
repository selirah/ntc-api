<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/17/2019
 * Time: 4:07 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\OUser;

class VUser
{
    private $_userOperation;

    public function __construct(OUser $userOperation)
    {
        $this->_userOperation = $userOperation;
    }

    public function __validateUserRegistration()
    {
        if (empty($this->_userOperation->name) || empty($this->_userOperation->email) || empty($this->_userOperation->phone)
            || empty($this->_userOperation->password) || empty($this->_userOperation->confirmPass)) {

            $response = [
                'error' => true,
                'message' => 'All fields are required'
            ];

            return ['response' => $response, 'code' => 400];
        }

        if (!filter_var($this->_userOperation->email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                'error' => true,
                'message' => 'Provide a valid email address in the format john@doe.com'
            ];
            return ['response' => $response, 'code' => 400];
        }

        if ($this->_userOperation->hasAgreed == false) {

            $response = [
                'error' => true,
                'message' => 'Make sure you agree to terms and conditions'
            ];

            return ['response' => $response, 'code' => 400];
        }

        if ($this->_userOperation->password != $this->_userOperation->confirmPass) {

            $response = [
                'error' => true,
                'message' => 'Passwords do not match'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateUserActivation()
    {
        if (empty($this->_userOperation->code)) {
            $response = [
                'error' => true,
                'message' => 'Code field is required'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateUserCodeResend()
    {
        if (empty($this->_userOperation->email)) {
            $response = [
                'error' => true,
                'message' => 'Email field is required'
            ];
            return ['response' => $response, 'code' => 400];
        }
        if (!filter_var($this->_userOperation->email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                'error' => true,
                'message' => 'Provide a valid email address in the format john@doe.com'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateUserLogin()
    {
        if (empty($this->_userOperation->loginParam) || empty($this->_userOperation->password)) {
            $response = [
                'error' => true,
                'message' => 'All fields are required.'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateUserProfile()
    {
        if (empty($this->_userOperation->name) || empty($this->_userOperation->email) || empty($this->_userOperation->phone)) {
            $response = [
                'error' => true,
                'message' => 'All fields are required'
            ];
            return ['response' => $response, 'code' => 400];
        }
        if (!filter_var($this->_userOperation->email, FILTER_VALIDATE_EMAIL)) {
            $response = [
                'error' => true,
                'message' => 'Provide a valid email address in the format john@doe.com'
            ];
            return ['response' => $response, 'code' => 400];
        }

        return true;
    }

    public function __validateUserPassword()
    {
        if (empty($this->_userOperation->password) || empty($this->_userOperation->oldPassword) || empty($this->_userOperation->confirmPass)) {
            $response = [
                'error' => true,
                'message' => 'All fields are required'
            ];
            return ['response' => $response, 'code' => 400];
        }
        if ($this->_userOperation->password != $this->_userOperation->confirmPass) {
            $response = [
                'error' => true,
                'message' => 'Passwords do not match'
            ];
            return ['response' => $response, 'code' => 400];
        }

        return true;
    }
}
