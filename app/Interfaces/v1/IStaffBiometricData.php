<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 1:44 PM
 */

namespace App\Interfaces\v1;


interface IStaffBiometricData
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();
}
