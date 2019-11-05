<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 10:22 AM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IProgramme;
use App\Models\v1\Programme;
use App\Validations\v1\VProgramme;
use Carbon\Carbon;


class OProgramme implements IProgramme
{
    private $_programme;
    private $_validation;

    public $programmeId;
    public $collegeId;
    public $programme;

    public function __construct(Programme $programme)
    {
        $this->_programme = $programme;
    }

    public function add()
    {
        $this->_validation = new VProgramme($this);
        // validate programme inputs
        $validation = $this->_validation->__validateProgrammeInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'programme' => $this->programme,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->programmeId = $this->_programme->_save($payload);

            $payload['id'] = $this->programmeId;

            $response = [
                'programme' => $payload
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VProgramme($this);
        // validate programme inputs
        $validation = $this->_validation->__validateProgrammeInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update programme
            $payload = [
                'programme' => $this->programme,
                'updated_at' => Carbon::now()
            ];

            $this->_programme->_update($this->programmeId, $payload);

            $programme = $this->_programme->_get($this->programmeId);

            $response = [
                'programme' => $programme
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
            $programme = $this->_programme->_get($this->programmeId);

            $response = [
                'programme' => ($programme) ? $programme : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get programme list
            $programmes = $this->_programme->_view($this->collegeId);

            $response = [
                'programmes' => ($programmes->isNotEmpty()) ? $programmes : []
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
