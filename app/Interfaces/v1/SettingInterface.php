<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 11:04 AM
 */

namespace App\Interfaces\v1;


interface SettingInterface
{
    public function addOrUpdate();

    public function get();

    public function view();

    public function delete();
}
