<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 2:00 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\StaffOperation;


class StaffValidation
{
    private $_staff;

    public function __construct(StaffOperation $staffOperation)
    {
        $this->_staff = $staffOperation;
    }

    public function __validateStaffInputs()
    {
        if (empty($this->_staff->staffId)
            || empty($this->_staff->title)
            || empty($this->_staff->name)
            || empty($this->_staff->category)
            || empty($this->_staff->position)
            || empty($this->_staff->email)
            || empty($this->_staff->phone)
            || empty($this->_staff->certificate)
            || empty($this->_staff->salary))
        {
            $response = [
                'error' => true,
                'message' => 'Required Fields: Staff ID, Title, Name, Staff Category, Staff Position, Email, Phone, Certificate, Annual Salary'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateStaffImport()
    {
        if (!$this->_staff->hasFile || empty($this->_staff->sheet) || empty($this->_staff->startRow)) {
            $response = [
                'error' => true,
                'message' => 'Make sure you select a file to upload'
            ];
            return ['response' => $response, 'code' => 400];
        }

        $extensions = ['xlsx', 'xls', 'csv'];
        if (!in_array($this->_staff->extension, $extensions)) {
            $response = [
                'error' => true,
                'message' => 'Make sure you upload an excel file of .xls, .xlsx or .csv extension'
            ];
            return ['response' => $response, 'code' => 400];
        }

        if ($this->_staff->size > 1048576) {
            $response = [
                'error' => true,
                'message' => 'Make sure the file does not exceed 1MB'
            ];
            return ['response' => $response, 'code' => 400];
        }

        return true;
    }
}
