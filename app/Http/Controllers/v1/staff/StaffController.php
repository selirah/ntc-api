<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 1:59 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\StaffOperation;
use Illuminate\Http\Request;


class StaffController extends Controller
{
    private $_staff;

    public function __construct(StaffOperation $staffOperation)
    {
        $this->_staff = $staffOperation;
    }

    // @route  POST api/v1/staff/add
    // @desc   Add Staff
    // @access Public
    public function add(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $this->_staff->staffId = trim($request->input('staff_id'));
        $this->_staff->title = trim($request->input('title'));
        $this->_staff->name = trim($request->input('name'));
        $this->_staff->dob = trim($request->input('dob'));
        $this->_staff->category = trim($request->input('staff_category'));
        $this->_staff->position = trim($request->input('staff_position'));
        $this->_staff->tinNumber = trim($request->input('tin_number'));
        $this->_staff->ssnitNumber = trim($request->input('ssnit_number'));
        $this->_staff->dateCommenced = trim($request->input('date_commenced'));
        $this->_staff->picture = trim($request->input('picture'));
        $this->_staff->email = trim($request->input('email'));
        $this->_staff->phone = trim($request->input('phone'));
        $this->_staff->certificate = trim($request->input('certificate')); //'PhD, Masters, Bachelor, Diploma, HND, Others, None, BECE, WASSCE'
        $this->_staff->salary = trim($request->input('salary'));
        $this->_staff->bonus = trim($request->input('bonus'));

        $response = $this->_staff->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/staff/update
    // @desc   Update Staff
    // @access Public
    public function update($id, Request $request)
    {
        $this->_staff->staffId = trim($request->input('staff_id'));
        $this->_staff->title = trim($request->input('title'));
        $this->_staff->name = trim($request->input('name'));
        $this->_staff->dob = trim($request->input('dob'));
        $this->_staff->category = trim($request->input('staff_category'));
        $this->_staff->position = trim($request->input('staff_position'));
        $this->_staff->tinNumber = trim($request->input('tin_number'));
        $this->_staff->ssnitNumber = trim($request->input('ssnit_number'));
        $this->_staff->dateCommenced = trim($request->input('date_commenced'));
        $this->_staff->picture = trim($request->input('picture'));
        $this->_staff->email = trim($request->input('email'));
        $this->_staff->phone = trim($request->input('phone'));
        $this->_staff->certificate = trim($request->input('certificate')); //'PhD, Masters, Bachelor, Diploma, HND, Others, None, BECE, WASSCE'
        $this->_staff->salary = trim($request->input('salary'));
        $this->_staff->bonus = trim($request->input('bonus'));
        $this->_staff->id = $id;

        $response = $this->_staff->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get?id=
    // @desc   Get Staff by ID
    // @access Public
    public function get(Request $request)
    {
        $this->_staff->id = $request->get('id');

        $response = $this->_staff->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/view
    // @desc   Get all staff list
    // @access Public
    public function view(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $response = $this->_staff->view();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get-staff-id?staff_id=
    // @desc   Get staff with staff ID
    // @access Public
    public function getWithStaffID(Request $request)
    {
        $this->_staff->staffId = $request->get('staff_id');

        $response = $this->_staff->getWithStaffId();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get-staff-category?category_id=
    // @desc   Get all staff list under a category
    // @access Public
    public function getWithCategory(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $this->_staff->category = $request->get('category_id');

        $response = $this->_staff->getWithCategory();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get-staff-position?position_id=
    // @desc   Get all staff list under a position
    // @access Public
    public function getWithPosition(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $this->_staff->position = $request->get('position_id');

        $response = $this->_staff->getWithPosition();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get-staff-category-position?category_id=&position_id=
    // @desc   Get all staff list under a category and position
    // @access Public
    public function getWithCategoryAndPosition(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $this->_staff->category = $request->get('category_id');
        $this->_staff->position = $request->get('position_id');

        $response = $this->_staff->getWithCategoryAndPosition();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff/get-staff-certificate?certificate=
    // @desc   Get all staff list under a certificate 'PhD, Masters, Bachelor, Diploma, HND, Others, None, BECE, WASSCE'
    // @access Public
    public function getWithCertificate(Request $request)
    {
        $this->_staff->collegeId = $request->user()->college_id;
        $this->_staff->certificate = $request->get('certificate');

        $response = $this->_staff->getWithCertificate();
        return response()->json($response['response'], $response['code']);
    }

    // @route  DELETE api/v1/staff/delete/:id
    // @desc   Delete Staff
    // @access Public
    public function delete($id)
    {
        $this->_staff->id = $id;

        $response = $this->_staff->delete();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/staff/import
    // @desc   Import Staff
    // @access Public
    public function import(Request $request)
    {
        $this->_staff->hasFile = $request->hasFile('excel');
        $this->_staff->excel = $request->file('excel');
        $this->_staff->sheet = trim($request->input('sheet'));
        $this->_staff->startRow = trim($request->input('start_row'));

        if ($this->_staff->hasFile) {
            $this->_staff->extension = $request->file('excel')->getClientOriginalExtension();
            $this->_staff->size = $request->file('excel')->getSize();
            $this->_staff->tmpPath = $request->file('excel')->getPathname();
        }

        $this->_staff->collegeId = $request->user()->college_id;

        $response = $this->_staff->import();
        return response()->json($response['response'], $response['code']);
    }

}
