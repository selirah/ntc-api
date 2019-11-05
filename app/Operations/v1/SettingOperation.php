<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 11:06 AM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\ISetting;
use App\Models\v1\Setting;
use App\Validations\v1\SettingValidation;
use Carbon\Carbon;

class SettingOperation implements ISetting
{
    private $_setting;
    private $_validation;

    public $settingId;
    public $collegeId;
    public $academicYear;
    public $semester;
    public $feePercentageFreshers;
    public $feePercentageContinuing;
    public $examStartDate;
    public $examEndDate;
    public $resultsUploadStartDate;
    public $resultsUploadEndDate;
    public $registrationStartDate;
    public $registrationEndDate;
    public $semesterVacationDate;
    public $nextSemesterReopeningDate;

    public function __construct(Setting $setting)
    {
        $this->_setting = $setting;
    }

    public function addOrUpdate()
    {
        $this->_validation = new SettingValidation($this);
        // validate settings inputs
        $validation = $this->_validation->__validateSettingsInputs();

        if ($validation !== true) {
            return $validation;
        }

        try {

            // check if college settings already exists
            $settings = $this->_setting->_view($this->collegeId);

            if ($settings) {
                // it exists so update
                $payload = [
                    'academic_year' => $this->academicYear,
                    'semester' => $this->semester,
                    'fee_percentage_freshers' => $this->feePercentageFreshers,
                    'fee_percentage_continuing' => $this->feePercentageContinuing,
                    'exam_start' => !empty($this->examStartDate) ? $this->examStartDate : null,
                    'exam_end' => !empty($this->examEndDate) ? $this->examEndDate : null,
                    'results_upload_start' => !empty($this->resultsUploadStartDate) ? $this->resultsUploadStartDate : null,
                    'results_upload_end' => !empty($this->resultsUploadEndDate) ? $this->resultsUploadEndDate : null,
                    'registration_start' => $this->registrationStartDate,
                    'registration_end' => $this->registrationEndDate,
                    'semester_vacation' => !empty($this->semesterVacationDate) ? $this->semesterVacationDate : null,
                    'next_semester_reopening' => !empty($this->nextSemesterReopeningDate) ? $this->nextSemesterReopeningDate : null,
                    'updated_at' => Carbon::now()
                ];

                $this->_setting->_update($this->settingId, $payload);

                $setting = $this->_setting->_get($this->settingId);

                $response = [
                    'settings' => $setting
                ];

                return ['response' => $response, 'code' => 201];
            } else {
                // add new settings
                $payload = [
                    'college_id' => $this->collegeId,
                    'academic_year' => $this->academicYear,
                    'semester' => $this->semester,
                    'fee_percentage_freshers' => $this->feePercentageFreshers,
                    'fee_percentage_continuing' => $this->feePercentageContinuing,
                    'exam_start' => !empty($this->examStartDate) ? $this->examStartDate : null,
                    'exam_end' => !empty($this->examEndDate) ? $this->examEndDate : null,
                    'results_upload_start' => !empty($this->resultsUploadStartDate) ? $this->resultsUploadStartDate : null,
                    'results_upload_end' => !empty($this->resultsUploadEndDate) ? $this->resultsUploadEndDate : null,
                    'registration_start' => $this->registrationStartDate,
                    'registration_end' => $this->registrationEndDate,
                    'semester_vacation' => !empty($this->semesterVacationDate) ? $this->semesterVacationDate : null,
                    'next_semester_reopening' => !empty($this->nextSemesterReopeningDate) ? $this->nextSemesterReopeningDate : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

                $this->settingId = $this->_setting->_save($payload);
                $payload['id'] = $this->settingId;

                $response = [
                    'settings' => $payload
                ];

                return ['response' => $response, 'code' => 201];

            }

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function get()
    {
        try {

            // get
            $settings = $this->_setting->_get($this->settingId);

            $response = [
                'settings' => ($settings) ? $settings : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get setting
            $settings = $this->_setting->_view($this->collegeId);

            $response = [
                'settings' => ($settings) ? $settings : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


}
