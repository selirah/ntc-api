<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 4:27 PM
 */

namespace App\Operations\v1;

use App\Models\v1\Course;
use App\Interfaces\v1\ICourse;
use App\Validations\v1\VCourse;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;


class OCourse implements ICourse
{
    private $_course;
    private $_validation;

    public $courseId;
    public $collegeId;
    public $departmentId;
    public $courseCode;
    public $courseName;
    public $creditHours;
    public $semester;
    public $hasFile;
    public $tmpPath;
    public $excel;
    public $extension;
    public $size;
    public $sheet;
    public $startRow;

    public function __construct(Course $course)
    {
        $this->_course = $course;
    }

    public function add()
    {
        $this->_validation = new VCourse($this);
        // validate inputs
        $validation = $this->_validation->__validateCourseInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'department_id' => $this->departmentId,
                'course_code' => $this->courseCode,
                'course_name' => $this->courseName,
                'credit_hours' => $this->creditHours,
                'semester' => $this->semester,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->courseId = $this->_course->_save($payload);

            $course = $this->_course->_get($this->courseId);

            $response = [
                'course' => $course
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VCourse($this);
        // validate inputs
        $validation = $this->_validation->__validateCourseInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'department_id' => $this->departmentId,
                'course_code' => $this->courseCode,
                'course_name' => $this->courseName,
                'credit_hours' => $this->creditHours,
                'semester' => $this->semester,
                'updated_at' => Carbon::now()
            ];

            $this->_course->_update($this->courseId, $payload);

            $course = $this->_course->_get($this->courseId);

            $response = [
                'course' => $course
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function get()
    {
        try {

            // get
            $course = $this->_course->_get($this->courseId);

            $response = [
                'course' => ($course) ? $course : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get list
            $courses = $this->_course->_view($this->collegeId);

            $response = [
                'courses' => ($courses->isNotEmpty()) ? $courses : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithDepartment()
    {
        try {

            // get list
            $courses = $this->_course->_getWithDepartmentId($this->collegeId, $this->departmentId);

            $response = [
                'courses' => ($courses->isNotEmpty()) ? $courses : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithSemester()
    {
        try {

            // get list
            $courses = $this->_course->_getWithSemester($this->collegeId, $this->semester);

            $response = [
                'courses' => ($courses->isNotEmpty()) ? $courses : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function import()
    {
        $this->_validation = new VCourse($this);
        $validation = $this->_validation->__validateCourseImport();

        if ($validation !== true) {
            return $validation;
        }

        try {

            // tear the excel sheet apart
            $fileType = IOFactory::identify($this->tmpPath);
            $reader = IOFactory::createReader($fileType);
            $spreadsheet = $reader->load($this->tmpPath);

            $sheet = $spreadsheet->getSheet($this->sheet - 1);

            $sheetData = $sheet->toArray(null, true, true, true);

            // clean the data from the excel sheet
            $cleanData = [];
            for ($row = $this->startRow; $row <= count($sheetData); $row++) {
                $cleanData[] = $sheetData[$row];
            }

            $staffData = [];
            $duplicates = [];

            foreach ($cleanData as $c) {
                if (!empty($c['A']) && !empty($c['B']) && !empty($c['C']) && !empty($c['D'])
                    && !empty($c['E'])) {
                    // check if course already exists in table
                    $check = $this->_course->_getWithCourseCode($this->collegeId, $c['A']);
                    if ($check) {
                        $duplicates[] = $check->course_code;
                    } else {
                        $staffData[] = [
                            'course_code' => $c['A'],
                            'college_id' => $this->collegeId,
                            'course_name' => $c['B'],
                            'department_id' => $c['C'],
                            'credit_hours' => $c['D'],
                            'semester' => $c['E'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }
                }
            }
            $this->_course->_saveBatch($staffData);

            $courses = $this->_course->_view($this->collegeId);

            $response = [
                'courses' => ($courses->isNotEmpty()) ? $courses : []
            ];

            return ['response' => $response, 'code' => 201];


        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
