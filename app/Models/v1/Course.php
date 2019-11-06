<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 4:21 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Course extends Model
{
    private $_connection;
    protected $table = 'courses';

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
        $query = $this->_connectTable()
            ->where($this->table . '.id', '=', $id)
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'departments.department')
            ->orderByDesc($this->table . '.created_at')
            ->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'departments.department')
            ->orderByDesc($this->table . '.created_at')
            ->get();
        return $query;
    }

    public function _getWithCourseCode($collegeId, $courseCode)
    {
        $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.course_code', '=', $courseCode)
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'departments.department')
            ->first();
    }

    public function _getWithDepartmentId($collegeId, $departmentId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.department_id', '=', $departmentId)
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'departments.department')
            ->orderByDesc($this->table . '.created_at')
            ->get();
        return $query;
    }

    public function _getWithSemester($collegeId, $semester)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.semester', '=', $semester)
            ->join('departments', $this->table . '.department_id', '=', 'departments.id')
            ->select($this->table . '.*', 'departments.department')
            ->orderByDesc($this->table . '.created_at')
            ->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }

}
