<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 3:11 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class AuthStudents extends Model
{
    private $_connection;
    protected $table = 'auth_students';

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
        $this->_connectTable()->insert($payload);
    }

    public function _update($studentId, array $payload)
    {
        $this->_connectTable()->where('student_id', '=', $studentId)->update($payload);
    }

    public function _getStudentAccount($studentId)
    {
        $query = $this->_connectTable()->where('student_id', '=', $studentId)->first();
        return $query;
    }

}
