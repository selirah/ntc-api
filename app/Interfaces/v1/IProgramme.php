<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/28/2019
 * Time: 10:22 AM
 */

namespace App\Interfaces\v1;


interface IProgramme
{

    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();
}
