<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 12:33 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MedicalRecord extends Model
{
    private $_connection;
    protected $table = 'medical_records';

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
            ->where('id', '=', $id)
            ->first();
        return $query;
    }

    public function _getWithStudentId($collegeId, $studentId)
    {
        $query = $this->_connectTable()
            ->where('college_id', '=', $collegeId)
            ->where('student_id', '=', $studentId)
            ->first();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
