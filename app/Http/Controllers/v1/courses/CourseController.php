<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OCourse;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    private $_course;

    public function __construct(OCourse $course)
    {
        $this->_course = $course;
    }

    // @route  POST api/v1/courses/add
    // @desc   Add Course
    // @access Public
    public function add(Request $request)
    {
        $this->_course->departmentId = trim($request->input('department_id'));
        $this->_course->courseCode = trim($request->input('course_code'));
        $this->_course->courseName = trim($request->input('course_name'));
        $this->_course->creditHours = trim($request->input('credit_hours'));
        $this->_course->semester = trim($request->input('semester'));
        $this->_course->collegeId = $request->user()->college_id;

        $response = $this->_course->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/courses/update
    // @desc   Update Course
    // @access Public
    public function update($id, Request $request)
    {
        $this->_course->departmentId = trim($request->input('department_id'));
        $this->_course->courseCode = trim($request->input('course_code'));
        $this->_course->courseName = trim($request->input('course_name'));
        $this->_course->creditHours = trim($request->input('credit_hours'));
        $this->_course->semester = trim($request->input('semester'));
        $this->_course->courseId = $id;

        $response = $this->_course->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/courses/get?id
    // @desc   Get Course
    // @access Public
    public function get(Request $request)
    {
        $this->_course->courseId = $request->get('id');

        $response = $this->_course->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/courses/view
    // @desc   Get course list
    // @access Public
    public function view(Request $request)
    {
        $this->_course->collegeId = $request->user()->college_id;
        $response = $this->_course->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/courses/get-department?department_id=
    // @desc   Get course list for given department
    // @access Public
    public function getWithDepartment(Request $request)
    {
        $this->_course->collegeId = $request->user()->college_id;
        $this->_course->departmentId = $request->get('department_id');

        $response = $this->_course->getWithDepartment();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/courses/get-semester?semester=
    // @desc   Get course list for given semester
    // @access Public
    public function getWithSemester(Request $request)
    {
        $this->_course->collegeId = $request->user()->college_id;
        $this->_course->semester = $request->get('semester');

        $response = $this->_course->getWithSemester();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/courses/import
    // @desc   Import Courses
    // @access Public
    public function import(Request $request)
    {
        $this->_course->hasFile = $request->hasFile('excel');
        $this->_course->excel = $request->file('excel');
        $this->_course->sheet = trim($request->input('sheet'));
        $this->_course->startRow = trim($request->input('start_row'));

        if ($this->_course->hasFile) {
            $this->_course->extension = $request->file('excel')->getClientOriginalExtension();
            $this->_course->size = $request->file('excel')->getSize();
            $this->_course->tmpPath = $request->file('excel')->getPathname();
        }

        $this->_course->collegeId = $request->user()->college_id;

        $response = $this->_course->import();
        return response()->json($response['response'], $response['code']);
    }


}
