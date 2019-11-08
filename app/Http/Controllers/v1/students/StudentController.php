<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 1:48 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OStudent;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    private $_student;

    public function __construct(OStudent $student)
    {
        $this->_student = $student;
    }

    // @route  POST api/v1/students/add
    // @desc   Add Student
    // @access Public
    public function add(Request $request)
    {
        $this->_student->collegeId = $request->user()->college_id;
        $this->_student->studentId = trim($request->input('student_id'));
        $this->_student->indexNumber = trim($request->input('index_number'));
        $this->_student->accountCode = trim($request->input('account_code'));
        $this->_student->programmeId = trim($request->input('programme_id'));
        $this->_student->departmentId = trim($request->input('department_id'));
        $this->_student->surname = trim($request->input('surname'));
        $this->_student->othernames = trim($request->input('othernames'));
        $this->_student->gender = trim($request->input('gender')); //M, F
        $this->_student->dob = trim($request->input('dob'));
        $this->_student->admissionYear = trim($request->input('admission_year'));
        $this->_student->hall = trim($request->input('hall'));
        $this->_student->address = trim($request->input('address'));
        $this->_student->email = trim($request->input('email'));
        $this->_student->phones = trim($request->input('phone_numbers'));
        $this->_student->picture = trim($request->input('picture'));
        $this->_student->nationality = trim($request->input('country'));
        $this->_student->status = env('STUDENT_STATUS_ACTIVE');
        $this->_student->paymentMode = trim($request->input('payment_mode'));

        $response = $this->_student->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/students/update
    // @desc   Update Student
    // @access Public
    public function update($id, Request $request)
    {
        $this->_student->studentId = trim($request->input('student_id'));
        $this->_student->indexNumber = trim($request->input('index_number'));
        $this->_student->accountCode = trim($request->input('account_code'));
        $this->_student->programmeId = trim($request->input('programme_id'));
        $this->_student->departmentId = trim($request->input('department_id'));
        $this->_student->surname = trim($request->input('surname'));
        $this->_student->othernames = trim($request->input('othernames'));
        $this->_student->gender = trim($request->input('gender')); //M, F
        $this->_student->dob = trim($request->input('dob'));
        $this->_student->admissionYear = trim($request->input('admission_year'));
        $this->_student->hall = trim($request->input('hall'));
        $this->_student->address = trim($request->input('address'));
        $this->_student->email = trim($request->input('email'));
        $this->_student->phones = trim($request->input('phone_numbers'));
        $this->_student->picture = trim($request->input('picture'));
        $this->_student->nationality = trim($request->input('country'));
        $this->_student->status = env('STUDENT_STATUS_ACTIVE');
        $this->_student->paymentMode = trim($request->input('payment_mode'));
        $this->_student->id = $id;

        $response = $this->_student->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get?id=
    // @desc   Get Student
    // @access Public
    public function get(Request $request)
    {
        $this->_student->id = trim($request->get('id'));

        $response = $this->_student->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/view
    // @desc   Get all students list
    // @access Public
    public function view(Request $request)
    {
        $this->_student->collegeId = $request->user()->college_id;
        $response = $this->_student->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-student-id?student_id=
    // @desc   Get student with student ID
    // @access Public
    public function getWithStudentID(Request $request)
    {
        $this->_student->studentId = trim($request->get('student_id'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithStudentId();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-student-index?index_number=
    // @desc   Get student with index number
    // @access Public
    public function getWithIndexNumber(Request $request)
    {
        $this->_student->indexNumber = trim($request->get('index_number'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithIndexNumber();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-student-account?account_code=
    // @desc   Get student with account code
    // @access Public
    public function getWithAccountCode(Request $request)
    {
        $this->_student->accountCode = trim($request->get('account_code'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithAccountCode();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-status?status=
    // @desc   Get students with status
    // @access Public
    public function getWithStatus(Request $request)
    {
        $this->_student->status = trim($request->get('status'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithStatus();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-programme?programme_id=
    // @desc   Get students with programme
    // @access Public
    public function getWithProgramme(Request $request)
    {
        $this->_student->programmeId = trim($request->get('programme_id'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithProgramme();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-department?department_id=
    // @desc   Get students with department
    // @access Public
    public function getWithDepartment(Request $request)
    {
        $this->_student->departmentId = trim($request->get('department_id'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithDepartment();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-admission?admission_year=
    // @desc   Get students with admission year
    // @access Public
    public function getWithAdmissionYear(Request $request)
    {
        $this->_student->admissionYear = trim($request->get('admission_year'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithAdmissionYear();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-gender?gender=
    // @desc   Get students with admission year
    // @access Public
    public function getWithGender(Request $request)
    {
        $this->_student->gender = trim($request->get('gender'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithGender();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-mode?payment_mode=
    // @desc   Get students with payment mode
    // @access Public
    public function getWithPaymentMode(Request $request)
    {
        $this->_student->paymentMode = trim($request->get('payment_mode'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithPaymentMode();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-year?year=
    // @desc   Get students with year
    // @access Public
    public function getWithYear(Request $request)
    {
        $this->_student->year = trim($request->get('year'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithYear();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-year-programme?year=&programme_id=
    // @desc   Get students with year and programme
    // @access Public
    public function getWithYearAndProgramme(Request $request)
    {
        $this->_student->year = trim($request->get('year'));
        $this->_student->programmeId = trim($request->get('programme_id'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithYearAndProgramme();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students/get-students-year-department?year=&department_id=
    // @desc   Get students with year and department
    // @access Public
    public function getWithYearAndDepartment(Request $request)
    {
        $this->_student->year = trim($request->get('year'));
        $this->_student->departmentId = trim($request->get('department_id'));
        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->getWithYearAndDepartment();
        return response()->json($response['response'], $response['code']);
    }


    // @route  POST api/v1/students/import
    // @desc   Import Students
    // @access Public
    public function import(Request $request)
    {
        $this->_student->hasFile = $request->hasFile('excel');
        $this->_student->excel = $request->file('excel');
        $this->_student->sheet = trim($request->input('sheet'));
        $this->_student->startRow = trim($request->input('start_row'));
        $this->_student->admissionYear = trim($request->input('admission_year'));
        $this->_student->programmeId = trim($request->input('programme_id'));
        $this->_student->status = env('STUDENT_STATUS_ACTIVE');

        if ($this->_student->hasFile) {
            $this->_student->extension = $request->file('excel')->getClientOriginalExtension();
            $this->_student->size = $request->file('excel')->getSize();
            $this->_student->tmpPath = $request->file('excel')->getPathname();
        }

        $this->_student->collegeId = $request->user()->college_id;

        $response = $this->_student->import();
        return response()->json($response['response'], $response['code']);
    }
}
