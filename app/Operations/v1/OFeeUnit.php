<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 11:18 AM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IFeeUnit;
use App\Models\v1\FeeUnit;
use App\Validations\v1\VFeeUnit;
use Carbon\Carbon;


class OFeeUnit implements IFeeUnit
{
    private $_feeUnit;
    private $_validation;

    public $id;
    public $collegeId;
    public $unit;

    public function __construct(FeeUnit $feeUnit)
    {
        $this->_feeUnit = $feeUnit;
    }

    public function add()
    {
        $this->_validation = new VFeeUnit($this);
        // validate input
        $validation = $this->_validation->__validateFeeUnitInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'unit' => $this->unit,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->id = $this->_feeUnit->_save($payload);

            $payload['id'] = $this->id;

            $response = [
                'unit' => $payload
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VFeeUnit($this);
        // validate input
        $validation = $this->_validation->__validateFeeUnitInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'unit' => $this->unit,
                'updated_at' => Carbon::now()
            ];

            $this->_feeUnit->_update($this->id, $payload);

            $unit = $this->_feeUnit->_get($this->id);

            $response = [
                'unit' => $unit
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
            $unit = $this->_feeUnit->_get($this->id);

            $response = [
                'unit' => ($unit) ? $unit : []
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
            $units = $this->_feeUnit->_view($this->collegeId);

            $response = [
                'units' => ($units->isNotEmpty()) ? $units : []
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
            $this->_feeUnit->_delete($this->id);
            $response = [
                'message' => 'deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
