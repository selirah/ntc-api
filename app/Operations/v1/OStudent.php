<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 11:30 AM
 */

namespace App\Operations\v1;

use App\Helpers\Helper;
use App\Interfaces\v1\IStudent;
use App\Models\v1\Student;
use App\Models\v1\AuthStudents;
use App\Models\v1\College;
use App\Validations\v1\VStudent;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OStudent implements IStudent
{
    private $_student;
    private $_authStudents;
    private $_college;
    private $_validation;

    public $id;
    public $collegeId;
    public $studentId;
    public $indexNumber;
    public $accountCode;
    public $programmeId;
    public $departmentId;
    public $surname;
    public $othernames;
    public $gender;
    public $dob;
    public $admissionYear;
    public $hall;
    public $address;
    public $email;
    public $phones;
    public $picture;
    public $nationality;
    public $status;
    public $paymentMode;
    public $year;
    public $hasFile;
    public $tmpPath;
    public $excel;
    public $extension;
    public $size;
    public $sheet;
    public $startRow;

    public function __construct(Student $student, AuthStudents $authStudents, College $college)
    {
        $this->_student = $student;
        $this->_authStudents = $authStudents;
        $this->_college = $college;
    }

    public function add()
    {
        $this->_validation = new VStudent($this);
        // validate
        $validation = $this->_validation->__validateStudentInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'student_id' => $this->studentId,
                'index_number' => $this->indexNumber,
                'account_code' => $this->accountCode,
                'programme_id' => $this->programmeId,
                'department_id' => $this->departmentId,
                'surname' => $this->surname,
                'othernames' => $this->othernames,
                'gender' => $this->gender,
                'dob' => $this->dob,
                'admission_year' => $this->admissionYear,
                'hall' => $this->hall,
                'address' => $this->address,
                'email' => $this->email,
                'phones' => $this->phones,
                'picture' => $this->picture,
                'nationality' => $this->nationality,
                'status' => $this->status,
                'payment_mode' => $this->paymentMode,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            // generate new student login credentials
            $college = $this->_college->_get($this->collegeId);
            $phones = explode('/', $this->phones);
            $password = Helper::generateRandomPassword();
            $phone = Helper::sanitizePhone($phones[0]);
            $apiToken = Helper::generateApiToken();
            $tokenExpiry = strtotime(date("Y-m-d H:i:s"));

            $auth = [
                'college_id' => $this->collegeId,
                'student_id' => $this->studentId,
                'password' => $password,
                'api_token' => $apiToken,
                'token_expiry' => $tokenExpiry,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->id = $this->_student->_save($payload);

            $this->_authStudents->_save($auth);

            $student = $this->_student->_get($this->id);

            $studentSMS[] = [
                'surname' => $this->surname,
                'othernames' => $this->othernames,
                'student_id' => $this->studentId,
                'password' => $password,
                'phone' => $phone,
            ];

            $helper = new Helper();
            $helper->sendBulkSMS($college, $studentSMS);


            $response = [
                'student' => $student
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VStudent($this);
        // validate
        $validation = $this->_validation->__validateStudentInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'student_id' => $this->studentId,
                'index_number' => $this->indexNumber,
                'account_code' => $this->accountCode,
                'programme_id' => $this->programmeId,
                'department_id' => $this->departmentId,
                'surname' => $this->surname,
                'othernames' => $this->othernames,
                'gender' => $this->gender,
                'dob' => $this->dob,
                'admission_year' => $this->admissionYear,
                'hall' => $this->hall,
                'address' => $this->address,
                'email' => $this->email,
                'phones' => $this->phones,
                'picture' => $this->picture,
                'nationality' => $this->nationality,
                'status' => $this->status,
                'payment_mode' => $this->paymentMode,
                'updated_at' => Carbon::now()
            ];

            $this->_student->_update($this->id, $payload);

            $student = $this->_student->_get($this->id);

            $response = [
                'student' => $student
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
            $student = $this->_student->_get($this->id);

            $response = [
                'student' => ($student) ? $student : []
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
            $students = $this->_student->_view($this->collegeId);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithStudentId()
    {
        try {
            // get
            $student = $this->_student->_getWithStudentId($this->collegeId, $this->studentId);

            $response = [
                'student' => ($student) ? $student : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithIndexNumber()
    {
        try {
            // get
            $student = $this->_student->_getWithIndexNumber($this->collegeId, $this->indexNumber);

            $response = [
                'student' => ($student) ? $student : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithAccountCode()
    {
        try {
            // get
            $student = $this->_student->_getWithAccountCode($this->collegeId, $this->accountCode);

            $response = [
                'student' => ($student) ? $student : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithStatus()
    {
        try {

            // get list
            $students = $this->_student->_getWithStatus($this->collegeId, $this->status);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithProgramme()
    {
        try {

            // get list
            $students = $this->_student->_getWithProgramme($this->collegeId, $this->programmeId);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
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
            $students = $this->_student->_getWithDepartment($this->collegeId, $this->departmentId);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithAdmissionYear()
    {
        try {

            // get list
            $students = $this->_student->_getWithAdmissionYear($this->collegeId, $this->admissionYear);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithGender()
    {
        try {

            // get list
            $students = $this->_student->_getWithGender($this->collegeId, $this->gender);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithPaymentMode()
    {
        try {

            // get list
            $students = $this->_student->_getWithFeePaymentMode($this->collegeId, $this->paymentMode);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithYear()
    {
        $this->admissionYear = (date('Y') + 1) - $this->year;

        try {

            // get list
            $students = $this->_student->_getWithAdmissionYear($this->collegeId, $this->admissionYear);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithYearAndProgramme()
    {
        $this->admissionYear = (date('Y') + 1) - $this->year;

        try {

            // get list
            $students = $this->_student->_getWithYearAndProgramme($this->collegeId, $this->admissionYear, $this->programmeId);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithYearAndDepartment()
    {
        $this->admissionYear = (date('Y') + 1) - $this->year;

        try {

            // get list
            $students = $this->_student->_getWithYearAndDepartment($this->collegeId, $this->admissionYear, $this->departmentId);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
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
        $this->_validation = new VStudent($this);
        $validation = $this->_validation->__validateStudentsImport();

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

            $studentsData = [];
            $duplicates = [];
            $authData = [];
            $studentSMS = [];

            $college = $this->_college->_get($this->collegeId);

            foreach ($cleanData as $c) {
                if (!empty($c['A']) && !empty($c['B']) && !empty($c['C']) && !empty($c['D'])
                    && !empty($c['E']) && !empty($c['F']) && !empty($c['G']) && !empty($c['H'])
                    && !empty($c['I']) && !empty($c['J']) && !empty($c['K']) && !empty($c['L'])) {

                    // check if staff already exists in table
                    $check = $this->_student->_getWithStudentId($this->collegeId, $c['A']);
                    if ($check) {
                        $duplicates[] = $check->student_id;
                    } else {
                        $studentsData[] = [
                            'college_id' => $this->collegeId,
                            'student_id' => trim($c['A']),
                            'index_number' => trim($c['B']),
                            'programme_id' => $this->programmeId,
                            'department_id' => trim($c['C']),
                            'surname' => trim($c['D']),
                            'othernames' => trim($c['E']),
                            'gender' => trim($c['F']),
                            'dob' => date('Y-m-d', strtotime(trim($c['G']))),
                            'admission_year' => $this->admissionYear,
                            'phones' => trim($c['H']),
                            'nationality' => trim($c['I']),
                            'payment_mode' => trim($c['J']),
                            'account_code' => trim($c['K']),
                            'email' => trim($c['L']),
                            'address' => trim($c['M']),
                            'hall' => trim($c['N']),
                            'status' => $this->status,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                        // generate new student login credentials
                        $phones = explode('/', $this->phones);
                        $password = Helper::generateRandomPassword();
                        $phone = Helper::sanitizePhone($phones[0]);
                        $apiToken = Helper::generateApiToken();
                        $tokenExpiry = strtotime(date("Y-m-d H:i:s"));

                        $authData[] = [
                            'college_id' => $this->collegeId,
                            'student_id' => trim($c['A']),
                            'password' => $password,
                            'api_token' => $apiToken,
                            'token_expiry' => $tokenExpiry,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                        $studentSMS[] = [
                            'surname' => $c['D'],
                            'othernames' => $c['E'],
                            'student_id' => $c['A'],
                            'password' => $password,
                            'phone' => $phone,
                        ];
                    }
                }
            }
            $this->_student->_saveBatch($studentsData);

            $this->_authStudents->_save($authData);

            $helper = new Helper();
            $helper->sendBulkSMS($college, $studentSMS);

            $students = $this->_student->_getWithStatus($this->collegeId, $this->status);

            $response = [
                'students' => ($students->isNotEmpty()) ? $students : []
            ];

            return ['response' => $response, 'code' => 201];


        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
