<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/23/2019
 * Time: 11:52 AM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OCollege;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    private $_college;

    public function __construct(OCollege $collegeOperation)
    {
        $this->_college = $collegeOperation;
    }

    // @route  GET api/v1/colleges/get?id
    // @desc   Get College
    // @access Public
    public function get(Request $request)
    {
        $this->_college->collegeId = $request->get('id');

        $response = $this->_college->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/colleges/add
    // @desc   Add College
    // @access Public
    public function add(Request $request)
    {
        $this->_college->name = trim($request->input('name'));
        $this->_college->email = trim($request->input('email'));
        $this->_college->phone = trim($request->input('phone'));
        $this->_college->region = trim($request->input('region'));
        $this->_college->senderId = trim($request->input('sender_id'));
        $this->_college->town = trim($request->input('town'));
        $this->_college->logo = trim($request->input('logo'));
        $this->_college->studentUrl = trim($request->input('student_url'));
        $this->_college->userId = $request->user()->id;

        $response = $this->_college->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/colleges/update
    // @desc   Update College
    // @access Public
    public function update($id, Request $request)
    {
        $this->_college->name = trim($request->input('name'));
        $this->_college->email = trim($request->input('email'));
        $this->_college->phone = trim($request->input('phone'));
        $this->_college->region = trim($request->input('region'));
        $this->_college->senderId = trim($request->input('sender_id'));
        $this->_college->town = trim($request->input('town'));
        $this->_college->logo = trim($request->input('logo'));
        $this->_college->studentUrl = trim($request->input('student_url'));
        $this->_college->collegeId = $id;

        $response = $this->_college->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/colleges/delete/:id
    // @desc   Delete College
    // @access Public
    public function delete($id)
    {
        $this->_college->collegeId = $id;

        $response = $this->_college->delete();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/colleges/view
    // @desc   Get College list
    // @access Public
    public function view()
    {
        $response = $this->_college->view();
        return response()->json($response['response'], $response['code']);
    }
}

