<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 4:30 PM
 */

namespace App\Validations\v1;

use App\Operations\v1\OCourse;


class VCourse
{
    private $_course;

    public function __construct(OCourse $course)
    {
        $this->_course = $course;
    }

    public function __validateCourseInputs()
    {
        if (empty($this->_course->departmentId)
            || empty($this->_course->courseCode)
            || empty($this->_course->courseName)
            || empty($this->_course->creditHours)
            || empty($this->_course->semester))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: department name, course name, course code, credit hours, semester'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }

    public function __validateCourseImport()
    {
        if (!$this->_course->hasFile
            || empty($this->_course->sheet)
            || empty($this->_course->startRow))
        {
            $response = [
                'error' => true,
                'message' => 'Required fields: Excel file, sheet number, start row'
            ];
            return ['response' => $response, 'code' => 400];
        }

        $extensions = ['xlsx', 'xls', 'csv'];
        if (!in_array($this->_course->extension, $extensions)) {
            $response = [
                'error' => true,
                'message' => 'Make sure you upload an excel file of .xls, .xlsx or .csv extension'
            ];
            return ['response' => $response, 'code' => 400];
        }

        if ($this->_course->size > 1048576) {
            $response = [
                'error' => true,
                'message' => 'Make sure the file does not exceed 1MB'
            ];
            return ['response' => $response, 'code' => 400];
        }

        return true;
    }
}
