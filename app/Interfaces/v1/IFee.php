<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 11/13/2019
 * Time: 12:42 PM
 */

namespace App\Interfaces\v1;


interface IFee
{
    public function add();

    public function update();

    public function get();

    public function view();

    public function getWithProgrammeAndAcademicYear();

    public function getWithPaymentModeAndAcademicYear();

    public function getWithStudentTypeAndAcademicYear();

    public function getFeeSumGroupByCurrency();

    public function delete();
}
