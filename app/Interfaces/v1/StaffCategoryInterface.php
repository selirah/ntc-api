<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 3:21 PM
 */

namespace App\Interfaces\v1;


interface StaffCategoryInterface
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function delete();
}
