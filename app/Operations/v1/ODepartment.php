<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 3:30 PM
 */

namespace App\Operations\v1;


use App\Models\v1\Department;
use App\Interfaces\v1\IDepartment;
use App\Validations\v1\VDepartment;
use Carbon\Carbon;

class ODepartment implements IDepartment
{
    private $_department;
    private $_validation;

    public $departmentId;
    public $collegeId;
    public $department;
    public $hod;
    public $programmeId;

    public function __construct(Department $department)
    {
        $this->_department = $department;
    }

    public function add()
    {
        $this->_validation = new VDepartment($this);
        // validate inputs
        $validation = $this->_validation->__validateDepartmentInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'programme_id' => $this->programmeId,
                'department' => $this->department,
                'hod' => $this->hod,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->departmentId = $this->_department->_save($payload);

            $department = $this->_department->_get($this->departmentId);

            $response = [
                'department' => $department
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VDepartment($this);
        // validate inputs
        $validation = $this->_validation->__validateDepartmentInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'programme_id' => $this->programmeId,
                'department' => $this->department,
                'hod' => $this->hod,
                'updated_at' => Carbon::now()
            ];

            $this->_department->_update($this->departmentId, $payload);

            $department = $this->_department->_get($this->departmentId);

            $response = [
                'department' => $department
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
            $department = $this->_department->_get($this->departmentId);

            $response = [
                'department' => ($department) ? $department : []
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
            $departments = $this->_department->_view($this->collegeId);

            $response = [
                'departments' => ($departments->isNotEmpty()) ? $departments : []
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
