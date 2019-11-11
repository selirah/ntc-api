<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 12:37 PM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IMedicalRecord;
use App\Models\v1\MedicalRecord;
use Carbon\Carbon;

class OMedicalRecord implements IMedicalRecord
{
    private $_medicalRecord;

    public $collegeId;
    public $recordId;
    public $studentId;
    public $diseaseName;
    public $isContagious;
    public $allergies;
    public $disability;

    public function __construct(MedicalRecord $record)
    {
        $this->_medicalRecord = $record;
    }

    public function get()
    {
        try {

            // get user medical record
            $record = $this->_medicalRecord->_getWithStudentId($this->collegeId, $this->studentId);

            $response = [
                'medical_record' => ($record) ? $record : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function add()
    {
        try {

            if (!empty($this->diseaseName) || !empty($this->isContagious) || !empty($this->allergies) || !empty($this->disability)) {
                // save
                $payload = [
                    'college_id' => $this->collegeId,
                    'student_id' => $this->studentId,
                    'disease_name' => $this->diseaseName,
                    'is_contagious' => $this->isContagious,
                    'allergies' => $this->allergies,
                    'disability' => $this->disability,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

                $this->recordId = $this->_medicalRecord->_save($payload);

                $payload['id'] = $this->recordId;

                $response = [
                    'medical_record' => $payload
                ];

                return ['response' => $response, 'code' => 201];
            } else {
                $response = [
                    'message' => 'At least one field should not be empty'
                ];

                return ['response' => $response, 'code' => 400];
            }

        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function update()
    {
        try {

            if (!empty($this->diseaseName) || !empty($this->isContagious) || !empty($this->allergies) || !empty($this->disability)) {
                // save
                $payload = [
                    'disease_name' => $this->diseaseName,
                    'is_contagious' => $this->isContagious,
                    'allergies' => $this->allergies,
                    'disability' => $this->disability,
                    'updated_at' => Carbon::now()
                ];

                $this->_medicalRecord->_update($this->recordId, $payload);

                $record = $this->_medicalRecord->_get($this->recordId);

                $response = [
                    'medical_record' => $record
                ];

                return ['response' => $response, 'code' => 201];
            } else {
                $response = [
                    'message' => 'At least one field should not be empty'
                ];

                return ['response' => $response, 'code' => 400];
            }
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            // delete medical record
            $this->_medicalRecord->_delete($this->recordId);
            $response = [
                'message' => 'record deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
