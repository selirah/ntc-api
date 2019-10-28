<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 3:21 PM
 */

namespace App\Validations\v1;


use App\Operations\v1\StaffCategoryOperation;

class StaffCategoryValidation
{
    private $_staffCategory;

    public function __construct(StaffCategoryOperation $staffCategoryOperation)
    {
        $this->_staffCategory = $staffCategoryOperation;
    }

    public function __validateStaffCategoryInputs()
    {
        if (empty($this->_staffCategory->category))
        {
            $response = [
                'error' =>true,
                'message' => 'Required Field: Category name'
            ];
            return ['response' => $response, 'code' => 400];
        }
        return true;
    }
}
