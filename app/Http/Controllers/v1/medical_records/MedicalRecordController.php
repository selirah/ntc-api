<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 1:07 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OMedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    private $_record;

    public function __construct(OMedicalRecord $record)
    {
        $this->_record = $record;
    }

    // @route  POST api/v1/medical-records/add
    // @desc   Add Student Medical Record
    // @access Public
    public function add(Request $request)
    {
        $this->_record->studentId = trim($request->input('student_id'));
        $this->_record->diseaseName = trim($request->input('disease_name'));
        $this->_record->isContagious = trim($request->input('is_contagious'));
        $this->_record->allergies = trim($request->input('allergies'));
        $this->_record->disability = trim($request->input('disability'));
        $this->_record->collegeId = $request->user()->college_id;

        $response = $this->_record->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/medical-records/update
    // @desc   Update Student Medical Record
    // @access Public
    public function update($id, Request $request)
    {
        $this->_record->diseaseName = trim($request->input('disease_name'));
        $this->_record->isContagious = trim($request->input('is_contagious'));
        $this->_record->allergies = trim($request->input('allergies'));
        $this->_record->disability = trim($request->input('disability'));
        $this->_record->recordId = $id;

        $response = $this->_record->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/medical-records/get?student_id
    // @desc   Get Student Medical Record
    // @access Public
    public function get(Request $request)
    {
        $this->_record->studentId = $request->get('student_id');
        $this->_record->collegeId = $request->user()->college_id;

        $response = $this->_record->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/medical-records/delete
    // @desc   Delete Student Medical Record
    // @access Public
    public function delete($id)
    {
        $this->_record->recordId = $id;

        $response = $this->_record->delete();
        return response()->json($response['response'], $response['code']);
    }
}
