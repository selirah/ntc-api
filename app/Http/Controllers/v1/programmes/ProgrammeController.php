<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 10:36 AM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OProgramme;
use Illuminate\Http\Request;


class ProgrammeController extends Controller
{
    private $_programme;

    public function __construct(OProgramme $programmeOperation)
    {
        $this->_programme = $programmeOperation;
    }

    // @route  POST api/v1/programmes/add
    // @desc   Add Programme
    // @access Public
    public function add(Request $request)
    {
        $this->_programme->programme = trim($request->input('programme'));
        $this->_programme->collegeId = $request->user()->college_id;

        $response = $this->_programme->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/programmes/update
    // @desc   Update Programme
    // @access Public
    public function update($id, Request $request)
    {
        $this->_programme->programme = trim($request->input('programme'));
        $this->_programme->programmeId = $id;

        $response = $this->_programme->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/programmes/get?id
    // @desc   Get Programme
    // @access Public
    public function get(Request $request)
    {
        $this->_programme->programmeId = $request->get('id');

        $response = $this->_programme->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/programmes/view
    // @desc   Get programme list
    // @access Public
    public function view(Request $request)
    {
        $this->_programme->collegeId = $request->user()->college_id;
        $response = $this->_programme->view();
        return response()->json($response['response'], $response['code']);
    }
}
