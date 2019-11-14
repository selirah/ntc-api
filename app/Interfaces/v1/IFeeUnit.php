<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 11:17 AM
 */

namespace App\Interfaces\v1;


interface IFeeUnit
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();
}
