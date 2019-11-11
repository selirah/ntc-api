<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 3:29 PM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IStudentBiometricData;
use App\Models\v1\StudentBiometricData;
use App\Validations\v1\VStudentBiometricData;
use Carbon\Carbon;

class OStudentBiometricData implements IStudentBiometricData
{
    private $_biometric;
    private $_validation;

    public $collegeId;
    public $id;
    public $studentId;
    public $templateKey;
    public $fingerOne;
    public $fingerTwo;

    public function __construct(StudentBiometricData $biometricData)
    {
        $this->_biometric = $biometricData;
    }

    public function add()
    {
        $this->_validation = new VStudentBiometricData($this);
        // validate inputs
        $validation = $this->_validation->__validateBiometricInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // check if staff already has biometric data
            $check = $this->_biometric->_getWithStudentId($this->collegeId, $this->studentId);

            if ($check) {
                $response = [
                    'message' => 'This particular staff already has biometric data saved'
                ];

                return ['response' => $response, 'code' => 201];
            }

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'student_id' => $this->studentId,
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
        $this->_validation = new VStudentBiometricData($this);
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
            $biometric = $this->_biometric->_getWithStudentId($this->collegeId, $this->studentId);

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
