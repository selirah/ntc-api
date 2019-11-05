<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 10:54 AM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    private $_connection;
    protected $table = 'departments';

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
        $query = $this->_connectTable()->where('id', '=', $id)->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()->where('college_id', '=', $collegeId)->get();
        return $query;
    }

    public function _getHODs($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('staff', $this->table . '.hod', '=', 'staff.id')
            ->join('programmes', $this->table . '.programme_id', '=', 'programmes.id')
            ->select($this->table . '.*', 'staff.staff_id', 'staff.title', 'staff.name', 'staff.phone', 'staff.email',
                'staff.certificate', 'staff.salary', 'staff.bonus', 'programmes.programme')
            ->orderByDesc($this->table . '.created_at')
            ->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
