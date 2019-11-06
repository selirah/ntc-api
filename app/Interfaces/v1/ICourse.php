<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/5/2019
 * Time: 4:16 PM
 */

namespace App\Interfaces\v1;


interface ICourse
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function getWithDepartment();

    public function getWithSemester();

    public function delete();

    public function import();

}
