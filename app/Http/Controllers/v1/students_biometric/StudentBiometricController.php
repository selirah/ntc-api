<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 3:37 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OStudentBiometricData;
use Illuminate\Http\Request;


class StudentBiometricController extends Controller
{
    private $_biometric;

    public function __construct(OStudentBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    // @route  POST api/v1/students-biometric/add
    // @desc   Add Student biometric data
    // @access Public
    public function add(Request $request)
    {
        $this->_biometric->studentId = trim($request->input('student_id'));
        $this->_biometric->templateKey = trim($request->input('template_key'));
        $this->_biometric->fingerOne = trim($request->input('finger_one'));
        $this->_biometric->fingerTwo = trim($request->input('finger_two'));
        $this->_biometric->collegeId = $request->user()->college_id;

        $response = $this->_biometric->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/students-biometric/update/id
    // @desc   Update student biometric data
    // @access Public
    public function update($id, Request $request)
    {
        $this->_biometric->studentId = trim($request->input('student_id'));
        $this->_biometric->templateKey = trim($request->input('template_key'));
        $this->_biometric->fingerOne = trim($request->input('finger_one'));
        $this->_biometric->fingerTwo = trim($request->input('finger_two'));
        $this->_biometric->id = $id;

        $response = $this->_biometric->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students-biometric/get?student_id
    // @desc   Get student biometric data
    // @access Public
    public function get(Request $request)
    {
        $this->_biometric->studentId = $request->get('student_id');
        $this->_biometric->collegeId = $request->user()->college_id;

        $response = $this->_biometric->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/students-biometric/view
    // @desc   Get students biometric list
    // @access Public
    public function view(Request $request)
    {
        $this->_biometric->collegeId = $request->user()->college_id;
        $response = $this->_biometric->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/students-biometric/delete
    // @desc   Delete student biometric data
    // @access Public
    public function delete($id)
    {
        $this->_biometric->id = $id;

        $response = $this->_biometric->delete();
        return response()->json($response['response'], $response['code']);
    }
}
