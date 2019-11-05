<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 9:55 AM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OStaffPosition;
use Illuminate\Http\Request;


class StaffPositionController extends Controller
{
    private $_position;

    public function __construct(OStaffPosition $staffPositionOperation)
    {
        $this->_position = $staffPositionOperation;
    }

    // @route  POST api/v1/staff-position/add
    // @desc   Add Staff Position
    // @access Public
    public function add(Request $request)
    {
        $this->_position->position = trim($request->input('position'));
        $this->_position->collegeId = $request->user()->college_id;

        $response = $this->_position->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/staff-position/update
    // @desc   Update Staff Position
    // @access Public
    public function update($id, Request $request)
    {
        $this->_position->position = trim($request->input('position'));
        $this->_position->positionId = $id;

        $response = $this->_position->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-position/get?id
    // @desc   Get Staff Position
    // @access Public
    public function get(Request $request)
    {
        $this->_position->positionId = $request->get('id');

        $response = $this->_position->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-position/view
    // @desc   Get staff position list
    // @access Public
    public function view(Request $request)
    {
        $this->_position->collegeId = $request->user()->college_id;
        $response = $this->_position->view();
        return response()->json($response['response'], $response['code']);
    }
}
