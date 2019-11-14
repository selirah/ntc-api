<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 12:43 PM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IFee;
use App\Models\v1\Fee;
use App\Validations\v1\VFee;
use Carbon\Carbon;


class OFee implements IFee
{
    private $_fee;
    private $_validation;

    public $id;
    public $collegeId;
    public $programmeId;
    public $academicYear;
    public $paymentMode;
    public $studentType;
    public $currency;
    public $amount;
    public $breakdown;

    public function __construct(Fee $fee)
    {
        $this->_fee = $fee;
    }

    public function add()
    {
        $this->_validation = new VFee($this);
        // validate input
        $validation = $this->_validation->__validateFeesInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'programme_id' => $this->programmeId,
                'academic_year' => $this->academicYear,
                'student_payment_mode' => $this->paymentMode,
                'student_type' => $this->studentType,
                'currency' => $this->currency,
                'amount' => $this->amount,
                'breakdown' => json_encode($this->breakdown),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->id = $this->_fee->_save($payload);

            $fee = $this->_fee->_get($this->id);

            $response = [
                'fee' => $fee
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VFee($this);
        // validate input
        $validation = $this->_validation->__validateFeesInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'programme_id' => $this->programmeId,
                'academic_year' => $this->academicYear,
                'student_payment_mode' => $this->paymentMode,
                'student_type' => $this->studentType,
                'currency' => $this->currency,
                'amount' => $this->amount,
                'breakdown' => json_encode($this->breakdown),
                'updated_at' => Carbon::now()
            ];

            $this->_fee->_update($this->id, $payload);

            $fee = $this->_fee->_get($this->id);

            $response = [
                'fee' => $fee
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function get()
    {
        try {

            // get
            $fee = $this->_fee->_get($this->id);

            $response = [
                'fee' => ($fee) ? $fee : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get list
            $fees = $this->_fee->_view($this->collegeId);

            $response = [
                'fees' => ($fees->isNotEmpty()) ? $fees : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithProgrammeAndAcademicYear()
    {
        try {

            // get list
            $fees = $this->_fee->_getWithProgrammeAndAcademicYear($this->collegeId, $this->programmeId, $this->academicYear);

            $response = [
                'fees' => ($fees->isNotEmpty()) ? $fees : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithPaymentModeAndAcademicYear()
    {
        try {

            // get list
            $fees = $this->_fee->_getWithPaymentModeAndAcademicYear($this->collegeId, $this->paymentMode, $this->academicYear);

            $response = [
                'fees' => ($fees->isNotEmpty()) ? $fees : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithStudentTypeAndAcademicYear()
    {
        try {

            // get list
            $fees = $this->_fee->_getWithStudentTypeAndAcademicYear($this->collegeId, $this->studentType, $this->academicYear);

            $response = [
                'fees' => ($fees->isNotEmpty()) ? $fees : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getFeeSumGroupByCurrency()
    {
        try {

            // get sum of fees based on currency
            $fees = $this->_fee->_getFeeSumGroupByCurrency($this->collegeId, $this->academicYear);

            $response = [
                'fees_sum' => ($fees->isNotEmpty()) ? $fees : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


    public function delete()
    {
        try {
            // delete
            $this->_fee->_delete($this->id);
            $response = [
                'message' => 'deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
