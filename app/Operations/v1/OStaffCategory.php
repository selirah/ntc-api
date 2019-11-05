<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 3:21 PM
 */

namespace App\Operations\v1;

use App\Interfaces\v1\IStaffCategory;
use App\Models\v1\StaffCategory;
use App\Validations\v1\VStaffCategory;
use Carbon\Carbon;


class OStaffCategory implements IStaffCategory
{
    private $_staffCategory;
    private $_validation;

    public $categoryId;
    public $collegeId;
    public $category;


    public function __construct(StaffCategory $staffCategory)
    {
        $this->_staffCategory = $staffCategory;
    }

    public function add()
    {
        $this->_validation = new VStaffCategory($this);
        // validate category inputs
        $validation = $this->_validation->__validateStaffCategoryInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'college_id' => $this->collegeId,
                'category' => $this->category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->categoryId = $this->_staffCategory->_save($payload);

            $payload['id'] = $this->categoryId;

            $response = [
                'category' => $payload
            ];

            return ['response' => $response, 'code' => 201];



        } catch (\Exception $e) {
            exit($e->getMessage());
        }

    }

    public function update()
    {
        $this->_validation = new VStaffCategory($this);
        // validate category inputs
        $validation = $this->_validation->__validateStaffCategoryInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update category
            $payload = [
                'category' => $this->category,
                'updated_at' => Carbon::now()
            ];

            $this->_staffCategory->_update($this->categoryId, $payload);

            $category = $this->_staffCategory->_get($this->categoryId);

            $response = [
                'category' => $category
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function get()
    {
        try {

            // get
            $category = $this->_staffCategory->_get($this->categoryId);

            $response = [
                'category' => ($category) ? $category : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get category list
            $categories = $this->_staffCategory->_view($this->collegeId);

            $response = [
                'categories' => ($categories->isNotEmpty()) ? $categories : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


}
