<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 12:10 PM
 */

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class FeeBreakdown extends Model
{
    private $_connection;
    protected $table = 'fees_breakdown';

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
}
