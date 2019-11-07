<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 11:31 AM
 */

namespace App\Validations\v1;

use App\Operations\v1\OStudent;


class VStudent
{
    private $_student;

    public function __construct(OStudent $student)
    {
        $this->_student = $student;
    }

    public function __validateStudentInputs()
    {
        if (empty($this->_student->studentId)
            || empty($this->_student->indexNumber)
            || empty($this->_student->programmeId)
            || empty($this->_student->departmentId)
            || empty($this->_student->surname)
            || empty($this->_student->othernames)
            || empty($this->_student->gender)
            || empty($this->_student->dob)
            || empty($this->_student->admissionYear)
            || empty($this->_student->phones)
            || empty($this->_student->nationality)
            || empty($this->_student->paymentMode))
        {
            $response = [
                'error' => true,
                'message' => 'Required Fields: Student ID, Index Number, Surname, Othernames, Gender, Date of Birth, Admission Year, Phone Numbers, Country, Fee Payment Mode'
            ];

            return ['response' => $response, 'code' => 400];
        }

        return true;
    }

    public function __validateStudentsImport()
    {
        if (!$this->_student->hasFile || empty($this->_student->sheet)
            || empty($this->_student->startRow)
            || empty($this->_student->programmeId)
            || empty($this->_student->admissionYear))
        {
            $response = [
                'error' => true,
                'message' => 'Required fields: Excel file, sheet number, start row, programme, admission year'
            ];
            return ['response' => $response, 'code' => 400];
        }

        $extensions = ['xlsx', 'xls', 'csv'];
        if (!in_array($this->_student->extension, $extensions)) {
            $response = [
                'error' => true,
                'message' => 'Make sure you upload an excel file of .xls, .xlsx or .csv extension'
            ];
            return ['response' => $response, 'code' => 400];
        }

        if ($this->_student->size > 1048576) {
            $response = [
                'error' => true,
                'message' => 'Make sure the file does not exceed 1MB'
            ];
            return ['response' => $response, 'code' => 400];
        }

        return true;
    }
}
