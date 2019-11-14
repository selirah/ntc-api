<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 11:31 AM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OFeeUnit;
use Illuminate\Http\Request;


class FeeUnitController extends Controller
{
    private $_feeUnit;

    public function __construct(OFeeUnit $feeUnit)
    {
        $this->_feeUnit = $feeUnit;
    }

    // @route  POST api/v1/fee-units/add
    // @desc   Add Fee Unit
    // @access Public
    public function add(Request $request)
    {
        $this->_feeUnit->unit = trim($request->input('unit'));
        $this->_feeUnit->collegeId = $request->user()->college_id;

        $response = $this->_feeUnit->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/fee-units/update
    // @desc   Update Fee Unit
    // @access Public
    public function update($id, Request $request)
    {
        $this->_feeUnit->unit = trim($request->input('unit'));
        $this->_feeUnit->id = $id;

        $response = $this->_feeUnit->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fee-units/get?id
    // @desc   Get Fee Unit
    // @access Public
    public function get(Request $request)
    {
        $this->_feeUnit->id = trim($request->get('id'));

        $response = $this->_feeUnit->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/fee-units/view
    // @desc   Get fee units list
    // @access Public
    public function view(Request $request)
    {
        $this->_feeUnit->collegeId = $request->user()->college_id;
        $response = $this->_feeUnit->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/fee-units/delete
    // @desc   Delete fee unit
    // @access Public
    public function delete($id)
    {
        $this->_feeUnit->id = $id;
        $response = $this->_feeUnit->delete();
        return response()->json($response['response'], $response['code']);
    }
}
