<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 1:29 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OFee;
use Illuminate\Http\Request;


class FeeController extends Controller
{
    private $_fee;

    public function __construct(OFee $fee)
    {
        $this->_fee = $fee;
    }

    // @route  POST api/v1/fees/add
    // @desc   Add Fee
    // @access Public
    public function add(Request $request)
    {
        $this->_fee->programmeId = trim($request->input('programme_id'));
        $this->_fee->academicYear = trim($request->input('academic_year'));
        $this->_fee->paymentMode = trim($request->input('payment_mode'));
        $this->_fee->studentType = trim($request->input('student_type'));
        $this->_fee->currency = trim($request->input('currency'));
        $this->_fee->amount = trim($request->input('amount'));
        $this->_fee->breakdown = $request->input('breakdown');
        $this->_fee->collegeId = $request->user()->college_id;

        $response = $this->_fee->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/fees/update/id.
    // @desc   Update Fee
    // @access Public
    public function update($id, Request $request)
    {
        $this->_fee->programmeId = trim($request->input('programme_id'));
        $this->_fee->academicYear = trim($request->input('academic_year'));
        $this->_fee->paymentMode = trim($request->input('payment_mode'));
        $this->_fee->studentType = trim($request->input('student_type'));
        $this->_fee->currency = trim($request->input('currency'));
        $this->_fee->amount = trim($request->input('amount'));
        $this->_fee->breakdown = $request->input('breakdown');
        $this->_fee->id = $id;

        $response = $this->_fee->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/get?id
    // @desc   Get Fee
    // @access Public
    public function get(Request $request)
    {
        $this->_fee->id = trim($request->get('id'));

        $response = $this->_fee->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/view
    // @desc   Get fees list
    // @access Public
    public function view(Request $request)
    {
        $this->_fee->collegeId = $request->user()->college_id;
        $response = $this->_fee->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/fees-programme?programme_id=&academic_year=
    // @desc   Get fees list with programme id and academic year
    // @access Public
    public function getWithProgrammeAndAcademicYear(Request $request)
    {
        $this->_fee->collegeId = $request->user()->college_id;
        $this->_fee->programmeId = trim($request->get('programme_id'));
        $this->_fee->academicYear = trim($request->get('academic_year'));
        $response = $this->_fee->getWithProgrammeAndAcademicYear();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/fees-payment-mode?payment_mode=&academic_year=
    // @desc   Get fees list with payment mode(regular/fee-paying/distant-learning/international) and academic year
    // @access Public
    public function getWithPaymentModeAndAcademicYear(Request $request)
    {
        $this->_fee->collegeId = $request->user()->college_id;
        $this->_fee->paymentMode = trim($request->get('payment_mode'));
        $this->_fee->academicYear = trim($request->get('academic_year'));
        $response = $this->_fee->getWithPaymentModeAndAcademicYear();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/fees-student-type?type=&academic_year=
    // @desc   Get fees list with student type(fresher/continuing) and academic year
    // @access Public
    public function getWithStudentTypeAndAcademicYear(Request $request)
    {
        $this->_fee->collegeId = $request->user()->college_id;
        $this->_fee->studentType = trim($request->get('type'));
        $this->_fee->academicYear = trim($request->get('academic_year'));
        $response = $this->_fee->getWithStudentTypeAndAcademicYear();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fees/fees-sum?academic_year=
    // @desc   Get sum of fees based on currency
    // @access Public
    public function getFeeSumGroupByCurrency(Request $request)
    {
        $this->_fee->collegeId = $request->user()->college_id;
        $this->_fee->academicYear = trim($request->get('academic_year'));
        $response = $this->_fee->getFeeSumGroupByCurrency();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/fees/delete
    // @desc   Delete fee unit
    // @access Public
    public function delete($id)
    {
        $this->_fee->id = $id;
        $response = $this->_fee->delete();
        return response()->json($response['response'], $response['code']);
    }

}
