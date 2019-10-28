<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 9:35 AM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class StaffPosition extends Model
{
    private $_connection;
    protected $table = 'staff_position';

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

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
