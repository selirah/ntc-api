<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 2:00 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    private $_connection;
    protected $table = 'staff';

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
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->first();
        return $query;
    }

    public function _getWithStaffId($id)
    {
        $query = $this->_connectTable()->where($this->table . '.staff_id', '=', $id)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->first();
        return $query;
    }

    public function _view($collegeId)
    {
        $query = $this->_connectTable()
            ->where($this->table . '.college_id', '=', $collegeId)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->orderByDesc('salary')
            ->get();
        return $query;
    }

    public function _getWithCategory($collegeId, $categoryId)
    {
        $query = $this->_connectTable()->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.staff_category', '=', $categoryId)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->orderByDesc('salary')
            ->get();
        return $query;
    }

    public function _getWithPosition($collegeId, $positionId)
    {
        $query = $this->_connectTable()->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.staff_position', '=', $positionId)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->orderByDesc('salary')
            ->get();
        return $query;
    }

    public function _getWithCategoryAndPosition($collegeId, $categoryId, $positionId)
    {
        $query = $this->_connectTable()->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.staff_category', '=', $categoryId)
            ->where($this->table . '.staff_position', '=', $positionId)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->select('staff.*', 'staff_category.category', 'staff_position.position')
            ->orderByDesc('salary')
            ->get();
        return $query;
    }

    public function _getWithCertificate($collegeId, $certificate)
    {
        $query = $this->_connectTable()->where($this->table . '.college_id', '=', $collegeId)
            ->where($this->table . '.certificate', '=', $certificate)
            ->join('staff_category', $this->table . '.staff_category', '=', 'staff_category.id')
            ->join('staff_position', $this->table . '.staff_position', '=', 'staff_position.id')
            ->orderByDesc('salary')
            ->get();
        return $query;
    }

    public function _delete($id)
    {
        $this->_connectTable()->delete($id);
    }
}
