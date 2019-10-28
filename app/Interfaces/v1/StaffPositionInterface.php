<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 9:38 AM
 */

namespace App\Interfaces\v1;


interface StaffPositionInterface
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();
}
