<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 12:09 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Fee extends Model
{
    private $_connection;
    protected $table = 'fees';

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

    public function _update($id, array $payload)
    {
        $this->_connectTable()->where('id', '=', $id)->update($payload);
    }

    public function _get($id)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.id', '=', $id)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('fee_payment_mode', $this->table . '.student_payment_mode', '=', 'fee_payment_mode.id')
            ->join('students_type', $this->table . '.student_type', '=', 'students_type.id')
            ->select($this->table . '.*', 'programmes.programme', 'fee_payment_mode.mode', 'students_type.type')
            ->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('fee_payment_mode', $this->table . '.student_payment_mode', '=', 'fee_payment_mode.id')
            ->join('students_type', $this->table . '.student_type', '=', 'students_type.id')
            ->select($this->table . '.*', 'programmes.programme', 'fee_payment_mode.mode', 'students_type.type')
            ->get();
        return $query;
    }


    public function _getWithProgrammeAndAcademicYear($collegeId, $programmeId, $academicYear)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.programme_id', '=', $programmeId)
            ->where($this->table . '.academic_year', '=', $academicYear)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('fee_payment_mode', $this->table . '.student_payment_mode', '=', 'fee_payment_mode.id')
            ->join('students_type', $this->table . '.student_type', '=', 'students_type.id')
            ->select($this->table . '.*', 'programmes.programme', 'fee_payment_mode.mode', 'students_type.type')
            ->get();
        return $query;
    }

    public function _getWithPaymentModeAndAcademicYear($collegeId, $status, $academicYear)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.student_payment_mode', '=', $status)
            ->where($this->table . '.academic_year', '=', $academicYear)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('fee_payment_mode', $this->table . '.student_payment_mode', '=', 'fee_payment_mode.id')
            ->join('students_type', $this->table . '.student_type', '=', 'students_type.id')
            ->select($this->table . '.*', 'programmes.programme', 'fee_payment_mode.mode', 'students_type.type')
            ->get();
        return $query;
    }

    public function _getWithStudentTypeAndAcademicYear($collegeId, $type, $academicYear)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.student_type', '=', $type)
            ->where($this->table . '.academic_year', '=', $academicYear)
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->join('fee_payment_mode', $this->table . '.student_payment_mode', '=', 'fee_payment_mode.id')
            ->join('students_type', $this->table . '.student_type', '=', 'students_type.id')
            ->select($this->table . '.*', 'programmes.programme', 'fee_payment_mode.mode', 'students_type.type')
            ->get();
        return $query;
    }

    public function _getFeeSumGroupByCurrency($collegeId, $academicYear)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.academic_year', '=', $academicYear)
            ->select($this->table . '.currency', DB::raw('SUM(amount) as amount'))
            ->groupBy($this->table . '.currency')
            ->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
