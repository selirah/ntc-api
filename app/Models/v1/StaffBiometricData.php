<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 1:36 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StaffBiometricData extends Model
{
    private $_connection;
    protected $table = 'staff_biometric_data';

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

    public function _getWithStaffId($collegeId, $staffId)
    {
        $query = $this->_connectTable()
            ->where('college_id', '=', $collegeId)
            ->where('staff_id', '=', $staffId)
            ->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('staff', $this->table . '.staff_id', '=', 'staff.staff_id')
            ->select('staff.*', $this->table . '.template_key', $this->table . '.finger_one', $this->table . '.finger_two')
            ->get();
        return $query;
    }


    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
