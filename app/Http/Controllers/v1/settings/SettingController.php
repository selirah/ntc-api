<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 11:35 AM
 */

namespace App\Http\Controllers;

use App\Operations\v1\OSetting;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    private $_setting;

    public function __construct(OSetting $settingOperation)
    {
        $this->_setting = $settingOperation;
    }

    // @route  POST api/v1/settings/add-update
    // @desc   Add or Update Settings
    // @access Public
    public function addOrUpdate(Request $request)
    {
        $this->_setting->collegeId = $request->user()->college_id;
        $this->_setting->settingId = trim($request->input('id'));
        $this->_setting->academicYear = trim($request->input('academic_year'));
        $this->_setting->semester = trim($request->input('semester'));
        $this->_setting->feePercentageFreshers = trim($request->input('fee_freshers_percentage'));
        $this->_setting->feePercentageContinuing = trim($request->input('fee_continuing_percentage'));
        $this->_setting->examStartDate = trim($request->input('exam_start_date'));
        $this->_setting->examEndDate = trim($request->input('exam_end_date'));
        $this->_setting->resultsUploadStartDate = trim($request->input('result_upload_start_date'));
        $this->_setting->resultsUploadEndDate = trim($request->input('result_upload_end_date'));
        $this->_setting->registrationStartDate = trim($request->input('registration_start_date'));
        $this->_setting->registrationEndDate = trim($request->input('registration_end_date'));
        $this->_setting->semesterVacationDate = trim($request->input('semester_vacation_date'));
        $this->_setting->nextSemesterReopeningDate = trim($request->input('next_semester_reopening_date'));

        $response = $this->_setting->addOrUpdate();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/settings/get?id
    // @desc   Get Settings
    // @access Public
    public function get(Request $request)
    {
        $this->_setting->settingId = $request->get('id');

        $response = $this->_setting->get();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/settings/view
    // @desc   Get settings
    // @access Public
    public function view(Request $request)
    {
        $this->_setting->collegeId = $request->user()->college_id;
        $response = $this->_setting->view();
        return response()->json($response['response'], $response['code']);
    }
}
