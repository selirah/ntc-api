<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 9:39 AM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IStaffPosition;
use App\Models\v1\StaffPosition;
use App\Validations\v1\VStaffPosition;
use Carbon\Carbon;


class OStaffPosition implements IStaffPosition
{
    private $_staffPosition;
    private $_validation;

    public $positionId;
    public $collegeId;
    public $position;

    public function __construct(StaffPosition $staffPosition)
    {
        $this->_staffPosition = $staffPosition;
    }

    public function add()
    {
        $this->_validation = new VStaffPosition($this);
        // validate position inputs
        $validation = $this->_validation->__validateStaffPositionInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'position' => $this->position,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->positionId = $this->_staffPosition->_save($payload);

            $payload['id'] = $this->positionId;

            $response = [
                'position' => $payload
            ];

            return ['response' => $response, 'code' => 201];



        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VStaffPosition($this);
        // validate position inputs
        $validation = $this->_validation->__validateStaffPositionInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update position
            $payload = [
                'position' => $this->position,
                'updated_at' => Carbon::now()
            ];

            $this->_staffPosition->_update($this->positionId, $payload);

            $category = $this->_staffPosition->_get($this->positionId);

            $response = [
                'position' => $category
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
            $position = $this->_staffPosition->_get($this->positionId);

            $response = [
                'position' => ($position) ? $position : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get position list
            $positions = $this->_staffPosition->_view($this->collegeId);

            $response = [
                'positions' => ($positions->isNotEmpty()) ? $positions : []
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
