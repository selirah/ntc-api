<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 3:10 PM
 */

namespace App\Interfaces\v1;


interface IDepartment
{

    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();

    public function getHODs();
}
