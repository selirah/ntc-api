<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 3:52 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\ODepartment;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    private $_department;

    public function __construct(ODepartment $department)
    {
        $this->_department = $department;
    }

    // @route  POST api/v1/departments/add
    // @desc   Add Department
    // @access Public
    public function add(Request $request)
    {
        $this->_department->department = trim($request->input('department'));
        $this->_department->hod = trim($request->input('hod'));
        $this->_department->programmeId = trim($request->input('programme'));
        $this->_department->collegeId = $request->user()->college_id;

        $response = $this->_department->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/departments/update
    // @desc   Update Department
    // @access Public
    public function update($id, Request $request)
    {
        $this->_department->department = trim($request->input('department'));
        $this->_department->hod = trim($request->input('hod'));
        $this->_department->programmeId = trim($request->input('programme'));
        $this->_department->departmentId = $id;

        $response = $this->_department->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/departments/get?id
    // @desc   Get Department
    // @access Public
    public function get(Request $request)
    {
        $this->_department->departmentId = $request->get('id');

        $response = $this->_department->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/departments/view
    // @desc   Get departments list
    // @access Public
    public function view(Request $request)
    {
        $this->_department->collegeId = $request->user()->college_id;
        $response = $this->_department->view();
        return response()->json($response['response'], $response['code']);
    }

}
