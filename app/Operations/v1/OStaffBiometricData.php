<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 1:45 PM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IStaffBiometricData;
use App\Models\v1\StaffBiometricData;
use App\Validations\v1\VStaffBiometricData;
use Carbon\Carbon;


class OStaffBiometricData implements IStaffBiometricData
{
    private $_biometric;
    private $_validation;

    public $collegeId;
    public $id;
    public $staffId;
    public $templateKey;
    public $fingerOne;
    public $fingerTwo;

    public function __construct(StaffBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    public function add()
    {
        $this->_validation = new VStaffBiometricData($this);
        // validate inputs
        $validation = $this->_validation->__validateBiometricInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // check if staff already has biometric data
            $check = $this->_biometric->_getWithStaffId($this->collegeId, $this->staffId);

            if ($check) {
                $response = [
                    'message' => 'This particular staff already has biometric data saved'
                ];

                return ['response' => $response, 'code' => 201];
            }

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'staff_id' => $this->staffId,
                'template_key' => $this->templateKey,
                'finger_one' => $this->fingerOne,
                'finger_two' => $this->fingerTwo,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->id = $this->_biometric->_save($payload);

            $payload['id'] = $this->id;

            $response = [
                'biometric' => $payload
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VStaffBiometricData($this);
        // validate inputs
        $validation = $this->_validation->__validateBiometricInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'template_key' => $this->templateKey,
                'finger_one' => $this->fingerOne,
                'finger_two' => $this->fingerTwo,
                'updated_at' => Carbon::now()
            ];

            $this->_biometric->_update($this->id, $payload);

            $biometric = $this->_biometric->_get($this->id);

            $response = [
                'biometric' => $biometric
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
            $biometric = $this->_biometric->_getWithStaffId($this->collegeId, $this->staffId);

            $response = [
                'biometric' => ($biometric) ? $biometric : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get  list
            $biometrics = $this->_biometric->_view($this->collegeId);

            $response = [
                'biometrics' => ($biometrics->isNotEmpty()) ? $biometrics : []
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
            $this->_biometric->_delete($this->id);
            $response = [
                'message' => 'deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
