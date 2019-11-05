<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/23/2019
 * Time: 11:55 AM
 */

namespace App\Interfaces\v1;


interface ICollege
{
    public function get();

    public function add();

    public function update();

    public function delete();

    public function view();
}
