<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/26/2019
 * Time: 2:00 PM
 */

namespace App\Operations\v1;

use App\Helpers\Helper;
use App\Interfaces\v1\IStaff;
use App\Models\v1\Staff;
use App\Validations\v1\VStaff;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;


class OStaff implements IStaff
{
    private $_staff;
    private $_validation;
    private $_category;
    private $_position;

    public $id;
    public $staffId;
    public $collegeId;
    public $title;
    public $name;
    public $dob;
    public $category;
    public $position;
    public $tinNumber;
    public $ssnitNumber;
    public $dateCommenced;
    public $picture;
    public $email;
    public $phone;
    public $certificate;
    public $salary;
    public $bonus;
    public $hasFile;
    public $tmpPath;
    public $excel;
    public $extension;
    public $size;
    public $sheet;
    public $startRow;

    public function __construct(Staff $staff)
    {
        $this->_staff = $staff;
    }

    public function add()
    {
        $this->_validation = new VStaff($this);
        // validate
        $validation = $this->_validation->__validateStaffInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save
            $payload = [
                'staff_id' => $this->staffId,
                'college_id' => $this->collegeId,
                'title' => $this->title,
                'name' => $this->name,
                'dob' => $this->dob,
                'staff_category' => $this->category,
                'staff_position' => $this->position,
                'tin_number' => $this->tinNumber,
                'ssnit_number' => $this->ssnitNumber,
                'date_commenced' => $this->dateCommenced,
                'picture' => $this->picture,
                'email' => $this->email,
                'phone' => Helper::sanitizePhone($this->phone),
                'certificate' => $this->certificate,
                'salary' => $this->salary,
                'bonus' => $this->bonus,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->id = $this->_staff->_save($payload);

            $staff = $this->_staff->_get($this->id);

            $response = [
                'staff' => $staff
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VStaff($this);
        // validate
        $validation = $this->_validation->__validateStaffInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update
            $payload = [
                'staff_id' => $this->staffId,
                'title' => $this->title,
                'name' => $this->name,
                'dob' => $this->dob,
                'staff_category' => $this->category,
                'staff_position' => $this->position,
                'tin_number' => $this->tinNumber,
                'ssnit_number' => $this->ssnitNumber,
                'date_commenced' => $this->dateCommenced,
                'picture' => $this->picture,
                'email' => $this->email,
                'phone' => Helper::sanitizePhone($this->phone),
                'certificate' => $this->certificate,
                'salary' => $this->salary,
                'bonus' => $this->bonus,
                'updated_at' => Carbon::now()
            ];

            $this->_staff->_update($this->id, $payload);

            $staff = $this->_staff->_get($this->id);

            $response = [
                'staff' => $staff
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
            $staff = $this->_staff->_get($this->id);

            $response = [
                'staff' => ($staff) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get list
            $staff = $this->_staff->_view($this->collegeId);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithStaffId()
    {
        try {
            // get
            $staff = $this->_staff->_getWithStaffId($this->collegeId, $this->staffId);

            $response = [
                'staff' => ($staff) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithCategory()
    {
        try {

            // get list
            $staff = $this->_staff->_getWithCategory($this->collegeId, $this->category);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithPosition()
    {
        try {

            // get list
            $staff = $this->_staff->_getWithPosition($this->collegeId, $this->position);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithCategoryAndPosition()
    {
        try {

            // get list
            $staff = $this->_staff->_getWithCategoryAndPosition($this->collegeId, $this->category, $this->position);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getWithCertificate()
    {
        try {

            // get list
            $staff = $this->_staff->_getWithCertificate($this->collegeId, $this->certificate);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            // delete staff
            $this->_staff->_delete($this->id);
            $response = [
                'message' => 'staff deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function import()
    {
        $this->_validation = new VStaff($this);
        $validation = $this->_validation->__validateStaffImport();

        if ($validation !== true) {
            return $validation;
        }

        try {

            // tear the excel sheet apart
            $fileType = IOFactory::identify($this->tmpPath);
            $reader = IOFactory::createReader($fileType);
            $spreadsheet = $reader->load($this->tmpPath);

            $sheet = $spreadsheet->getSheet($this->sheet - 1);

            $sheetData = $sheet->toArray(null, true, true, true);

            // clean the data from the excel sheet
            $cleanData = [];
            for ($row = $this->startRow; $row <= count($sheetData); $row++) {
                $cleanData[] = $sheetData[$row];
            }

            $staffData = [];
            $duplicates = [];

            foreach ($cleanData as $c) {
                if (!empty($c['A']) && !empty($c['B']) && !empty($c['C']) && !empty($c['E'])
                    && !empty($c['F']) && !empty($c['J']) && !empty($c['K']) && !empty($c['L'])
                    && !empty($c['M'])) {
                    // check if staff already exists in table
                    $check = $this->_staff->_getWithStaffId($this->collegeId, $c['A']);
                    if ($check) {
                        $duplicates[] = $check->staff_id;
                    } else {
                        $staffData[] = [
                            'staff_id' => trim($c['A']),
                            'college_id' => $this->collegeId,
                            'title' => trim($c['B']),
                            'name' => trim($c['C']),
                            'dob' => date('Y-m-d', strtotime($c['D'])),
                            'staff_category' => trim($c['E']),
                            'staff_position' => trim($c['F']),
                            'tin_number' => trim($c['G']),
                            'ssnit_number' => trim($c['H']),
                            'date_commenced' => date('Y-m-d', strtotime(trim($c['I']))),
                            'email' => trim($c['J']),
                            'phone' => Helper::sanitizePhone(trim($c['K'])),
                            'certificate' => trim($c['L']),
                            'salary' => trim($c['M']),
                            'bonus' => trim($c['N']),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    }
                }
            }
            $this->_staff->_saveBatch($staffData);

            $staff = $this->_staff->_view($this->collegeId);

            $response = [
                'staff' => ($staff->isNotEmpty()) ? $staff : []
            ];

            return ['response' => $response, 'code' => 201];


        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

}
