<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 3:22 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\StaffCategoryOperation;
use Illuminate\Http\Request;


class StaffCategoryController extends Controller
{
    private $_category;

    public function __construct(StaffCategoryOperation $staffCategoryOperation)
    {
        $this->_category = $staffCategoryOperation;
    }

    // @route  POST api/v1/staff-category/add
    // @desc   Add Staff Category
    // @access Public
    public function add(Request $request)
    {
        $this->_category->category = trim($request->input('category'));
        $this->_category->collegeId = $request->user()->college_id;

        $response = $this->_category->add();
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/staff-category/update
    // @desc   Update Staff Category
    // @access Public
    public function update($id, Request $request)
    {
        $this->_category->category = trim($request->input('category'));
        $this->_category->categoryId = $id;

        $response = $this->_category->update();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-category/get?id
    // @desc   Get Staff Category
    // @access Public
    public function get(Request $request)
    {
        $this->_category->categoryId = $request->get('id');

        $response = $this->_category->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/staff-category/view
    // @desc   Get staff category list
    // @access Public
    public function view(Request $request)
    {
        $this->_category->collegeId = $request->user()->college_id;
        $response = $this->_category->view();
        return response()->json($response['response'], $response['code']);
    }
}
