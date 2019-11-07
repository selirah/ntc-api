<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/23/2019
 * Time: 11:59 AM
 */

namespace App\Operations\v1;


use App\Helpers\Helper;
use App\Interfaces\v1\ICollege;
use App\Models\v1\College;
use App\Models\v1\User;
use App\Validations\v1\VCollege;
use Carbon\Carbon;

class OCollege implements ICollege
{
    private $_college;
    private $_user;
    private $_validation;

    public $collegeId;
    public $userId;
    public $name;
    public $region;
    public $town;
    public $email;
    public $phone;
    public $senderId;
    public $logo;
    public $studentUrl;

    public function __construct(College $college, User $user)
    {
        $this->_college = $college;
        $this->_user = $user;
    }

    public function get()
    {
        try {

            // get user college
            $college = $this->_college->_get($this->collegeId);

            $response = [
                'college' => ($college) ? $college : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function add()
    {
        $this->_validation = new VCollege($this);
        // validate college inputs
        $validation = $this->_validation->__validateCollegeInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {

            // save college
            $payload = [
                'user_id' => $this->userId,
                'name' => $this->name,
                'region' => $this->region,
                'town' => $this->town,
                'email' => $this->email,
                'phone' => Helper::sanitizePhone($this->phone),
                'sender_id' => $this->senderId,
                'logo' => $this->logo,
                'student_url' => $this->studentUrl,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->collegeId = $this->_college->_save($payload);

            // we will use the id of the newly created institution to update the users table, the institution_id field
            $this->_user->_update($this->userId, ['college_id' => $this->collegeId]);

            // add new institution id to payload to return to user
            $payload['id'] = $this->collegeId;

            // fetch user back to update institution id on front end
            $user = $this->_user->_getUser($this->userId);

            $response = [
                'auth' => [
                    'college_id' => $user->college_id,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'name' => $user->name,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ],
                'college' => $payload
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function update()
    {
        $this->_validation = new VCollege($this);
        // validate college inputs
        $validation = $this->_validation->__validateCollegeInputs();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // update college
            $payload = [
                'name' => $this->name,
                'region' => $this->region,
                'town' => $this->town,
                'email' => $this->email,
                'phone' => Helper::sanitizePhone($this->phone),
                'sender_id' => $this->senderId,
                'logo' => $this->logo,
                'student_url' => $this->studentUrl,
                'updated_at' => Carbon::now()
            ];

            $this->_college->_update($this->collegeId, $payload);

            $college = $this->_college->_get($this->collegeId);

            $response = [
                'college' => $college
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            // delete college
            $this->_college->_delete($this->collegeId);
            $response = [
                'message' => 'college deleted successfully',
            ];

            return ['response' => $response, 'code' => 204];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function view()
    {
        try {

            // get college list
            $colleges = $this->_college->_view();

            $response = [
                'colleges' => ($colleges->isNotEmpty()) ? $colleges : []
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }


}
