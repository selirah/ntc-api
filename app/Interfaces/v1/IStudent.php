<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/7/2019
 * Time: 11:23 AM
 */

namespace App\Interfaces\v1;


interface IStudent
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function getWithStudentId();

    public function getWithIndexNumber();

    public function getWithAccountCode();

    public function getWithStatus();

    public function getWithProgramme();

    public function getWithDepartment();

    public function getWithAdmissionYear();

    public function getWithGender();

    public function getWithPaymentMode();

    public function getWithYear();

    public function delete();

    public function import();
}
