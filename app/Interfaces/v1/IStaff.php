<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 1:59 PM
 */

namespace App\Interfaces\v1;


interface IStaff
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function getWithStaffId();

    public function getWithCategory();

    public function getWithPosition();

    public function getWithCategoryAndPosition();

    public function getWithCertificate();

    public function delete();

    public function import();
}
