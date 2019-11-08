<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 11:04 AM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Student extends Model
{
    private $_connection;
    protected $table = 'students';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->_connection = DB::connection('mysql');
    }

    private function _connectTable()
    {
        $table = $this->_connection->table($this->table);
        return $table;
    }

    public function _save(array $payload)
    {
        $id = $this->_connectTable()->insertGetId($payload);
        return $id;
    }

    public function _saveBatch(array $payload)
    {
        $this->_connectTable()->insertOrIgnore($payload);
    }

    public function _update($id, array $payload)
    {
        $this->_connectTable()->where('id', '=', $id)->update($payload);
    }

    public function _get($id)
    {
        $query = $this->_connectTable()->where($this->table . '.id', '=', $id)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->first();
        return $query;
    }

    public function _getWithStudentId($collegeId, $studentId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.student_id', '=', $studentId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->first();
        return $query;
    }

    public function _getWithIndexNumber($collegeId, $indexNumber)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.index_number', '=', $indexNumber)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->first();
        return $query;
    }

    public function _getWithAccountCode($collegeId, $accountCode)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.account_code', '=', $accountCode)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithStatus($collegeId, $status)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.status', '=', $status)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithProgramme($collegeId, $programmeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.programme_id', '=', $programmeId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithDepartment($collegeId, $departmentId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.department_id', '=', $departmentId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithAdmissionYear($collegeId, $admissionYear)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.admission_year', '=', $admissionYear)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithGender($collegeId, $gender)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.gender', '=', $gender)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithFeePaymentMode($collegeId, $paymentMode)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.payment_mode', '=', $paymentMode)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithYearAndProgramme($collegeId, $admissionYear, $programmeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.admission_year', '=', $admissionYear)
            ->where($this->table . '.programme_id', '=', $programmeId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _getWithYearAndDepartment($collegeId, $admissionYear, $departmentId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.admission_year', '=', $admissionYear)
            ->where($this->table . '.department_id', '=', $departmentId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'programmes.programme', 'departments.department')
            ->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }

}
