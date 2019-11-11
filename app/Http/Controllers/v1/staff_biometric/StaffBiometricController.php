<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 2:10 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OStaffBiometricData;
use Illuminate\Http\Request;


class StaffBiometricController extends Controller
{
    private $_biometric;

    public function __construct(OStaffBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    // @route  POST api/v1/staff-biometric/add
    // @desc   Add Staff biometric data
    // @access Public
    public function add(Request $request)
    {
        $this->_biometric->staffId = trim($request->input('staff_id'));
        $this->_biometric->templateKey = trim($request->input('template_key'));
        $this->_biometric->fingerOne = trim($request->input('finger_one'));
        $this->_biometric->fingerTwo = trim($request->input('finger_two'));
        $this->_biometric->collegeId = $request->user()->college_id;

        $response = $this->_biometric->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/staff-biometric/update/id
    // @desc   Update staff biometric data
    // @access Public
    public function update($id, Request $request)
    {
        $this->_biometric->staffId = trim($request->input('staff_id'));
        $this->_biometric->templateKey = trim($request->input('template_key'));
        $this->_biometric->fingerOne = trim($request->input('finger_one'));
        $this->_biometric->fingerTwo = trim($request->input('finger_two'));
        $this->_biometric->id = $id;

        $response = $this->_biometric->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-biometric/get?staff_id
    // @desc   Get staff biometric data
    // @access Public
    public function get(Request $request)
    {
        $this->_biometric->staffId = $request->get('staff_id');
        $this->_biometric->collegeId = $request->user()->college_id;

        $response = $this->_biometric->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-biometric/view
    // @desc   Get staff biometric list
    // @access Public
    public function view(Request $request)
    {
        $this->_biometric->collegeId = $request->user()->college_id;
        $response = $this->_biometric->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/staff-biometric/delete
    // @desc   Delete staff biometric data
    // @access Public
    public function delete($id)
    {
        $this->_biometric->id = $id;

        $response = $this->_biometric->delete();
        return response()->json($response['response'], $response['code']);
    }
}
