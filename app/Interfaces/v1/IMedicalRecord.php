<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/11/2019
 * Time: 12:36 PM
 */

namespace App\Interfaces\v1;


interface IMedicalRecord
{
    public function get();

    public function add();

    public function update();

    public function delete();
}
