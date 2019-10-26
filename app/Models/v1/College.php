<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/17/2019
 * Time: 4:15 PM
 */

namespace App\Models\v1;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class College extends Model
{
    private $_connection;
    protected $table = 'colleges';

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

    public function _view()
    {
        $query = $this->_connectTable()->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
