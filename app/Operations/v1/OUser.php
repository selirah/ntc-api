<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/17/2019
 * Time: 3:55 PM
 */

namespace App\Operations\v1;

use App\Helpers\Helper;
use App\Models\v1\User;
use App\Interfaces\v1\IUser;
use App\Models\v1\Code;
use App\Models\v1\College;
use App\Validations\v1\VUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class OUser implements IUser
{
    private $_user;
    private $_code;
    private $_validation;

    public $userId;
    public $email;
    public $parentId;
    public $password;
    public $confirmPass;
    public $phone;
    public $name;
    public $role;
    public $isVerified;
    public $isRevoked;
    public $avatar;
    public $hasAgreed;
    public $oldPassword;
    public $loginParam;

    public $code;
    public $isExpired;
    public $expiryDate;
    public $loginType;

    public function __construct(User $user, Code $code)
    {
        $this->_user = $user;
        $this->_code = $code;
    }

    public function registerUser()
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserRegistration();

        if ($validation !== true) {
            return $validation;
        }

        try {
            // Check if email and phone already exist
            $checkEmail = $this->_user->_checkEmailExistence($this->email);
            $checkPhone = $this->_user->_checkPhoneExistence($this->phone);
            if ($checkEmail) {
                $response = [
                    'error' => true,
                    'message' => 'Email ' . $this->email . ' already exists'
                ];
                return ['response' => $response, 'code' => 400];
            }
            if ($checkPhone) {
                $response = [
                    'error' => true,
                    'message' => 'Phone number ' . $this->phone . ' already exists'
                ];
                return ['response' => $response, 'code' => 400];
            }

            // generate an api token for user
            $apiToken = Helper::generateApiToken();
            $tokenExpiry = strtotime(date("Y-m-d H:i:s"));

            // Prepare data for DB
            $user = [
                'email' => $this->email,
                'phone' => Helper::sanitizePhone($this->phone),
                'name' => $this->name,
                'password' => Hash::make($this->password),
                'api_token' => $apiToken,
                'token_expiry' => $tokenExpiry,
                'role' => env('ROLE_ADMIN'),
                'avatar' => Helper::generateGravatar($this->email),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            // Save user data
            $userId = $this->_user->_save($user);
            $code = Helper::generateCode();
            $codeData = [
                'user_id' => $userId,
                'code' => $code,
                'expiry' => date("Y-m-d H:i:s", strtotime('+24 hours')),
                'is_expired' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            // save activation code info
            $this->_code->_save($codeData);

            // send SMS to user with code attached
            $message = "Thank you for registering. Your verification code is " . $code . " Thank you.";

            Helper::sendSMS($this->phone, urlencode($message));

            $response = [
                'message' => 'You have successfully registered',
                'email' => $this->email
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function loginUser(Request $request)
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserLogin();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $userId = null;
            // Attempt to log user in using email or phone
            switch ($this->loginType) {
                case env('LOGIN_EMAIL'):
                    $user = $this->_user->_getUserWithEmail($this->loginParam);
                    if (!$user) {
                        $response = [
                            'error' => true,
                            'message' => 'Invalid email or password'
                        ];
                        return ['response' => $response, 'code' => 401];
                    }

                    // check if user is authentic
                    $isAuthenticated = $this->_user->_authenticateUser($user->id, $this->isVerified, $this->isRevoked);
                    if (!$isAuthenticated) {
                        $response = [
                            'error' => true,
                            'message' => 'Either account is not verified or you have been denied access to the system'
                        ];
                        return ['response' => $response, 'code' => 401];
                    }

                    // check input password against user password
                    if (!Hash::check($this->password, $user->password)) {
                       $response = [
                           'error' => true,
                           'message' => 'Invalid email or password'
                       ];
                        return ['response' => $response, 'code' => 401];
                    }
                    // generate an api token for user
                    $apiToken = Helper::generateApiToken();
                    $tokenExpiry = strtotime(date("Y-m-d H:i:s", strtotime('+3 hours')));

                    $payload = [
                        'api_token' => $apiToken,
                        'token_expiry' => $tokenExpiry
                    ];

                    // update user api token
                    $this->_user->_update($user->id, $payload);
                    $userId = $user->id;
                    break;

                case env('LOGIN_PHONE'):
                    $user = $this->_user->_getUserWithPhone(Helper::sanitizePhone($this->loginParam));
                    if (!$user) {
                        $response = [
                            'error' => true,
                            'message' => 'Invalid phone or password'
                        ];
                        return ['response' => $response, 'code' => 400];
                    }

                    // check if user is authentic
                    $isAuthenticated = $this->_user->_authenticateUser($user->id, $this->isVerified, $this->isRevoked);
                    if (!$isAuthenticated) {
                        $response = [
                            'error' => true,
                            'message' => 'Either account is not verified or you have been denied access to the system'
                        ];
                        return ['response' => $response, 'code' => 400];
                    }

                    // check input password against user password
                    if (!Hash::check($this->password, $user->password)) {
                        $response = [
                            'error' => true,
                            'message' => 'Invalid phone or password'
                        ];
                        return ['response' => $response, 'code' => 401];
                    }
                    // generate an api token for user
                    $apiToken = Helper::generateApiToken();
                    $tokenExpiry = strtotime(date("Y-m-d H:i:s", strtotime('+3 hours')));

                    $payload = [
                        'api_token' => $apiToken,
                        'token_expiry' => $tokenExpiry
                    ];

                    // update user api token
                    $this->_user->_update($user->id, $payload);
                    $userId = $user->id;
                    break;
            }

            // get user
            $user = $this->_user->_getUser($userId);

            // get user college, if they have one set
            $_college = new College();
            $college = $_college->_get($user->college_id);

            // prepare auth data
            $response = [
                'auth' => [
                    'college_id' => $user->college_id,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'name' => $user->name,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                    'token' => 'Bearer ' . $user->api_token,
                    'token_exp' => $user->token_expiry
                ],
                'college' => ($college) ? $college : [],
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function activateUser()
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserActivation();
        if ($validation !== true) {
            return $validation;
        }

        try {
            // Check if user exist
            $user = $this->_user->_getUserWithEmail($this->email);
            if (!$user) {
                $response = [
                    'error' => true,
                    'message' => 'This email is not registered on our system.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            $userId = $user->id;

            // Check activation code if it exist
            $code = $this->_code->_getCode($userId, $this->code);
            if (!$code) {
                $response = [
                    'error' => true,
                    'message' => 'Invalid verification code. Try again.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            // Define a logic to update DB when code is expired
            if (strtotime(date('Y-m-d H:i:s')) > strtotime($code->expiry)) {
                $payload = [
                    'is_expired' => 1
                ];
                $this->_code->_update($userId, $payload);
                $response = [
                    'error' => true,
                    'message' => 'Activation code has expired.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            $payload = [
                'is_verified' => env('STATUS_ACTIVE'),
                'email_verified_at' => Carbon::now()
            ];
            // Activate User
            $this->_user->_update($userId, $payload);

            //We have to force expire the code after user is done activating
            $this->_code->_expireCode($userId, $this->code, ['is_expired' => 1]);
            $response = [
                'message' => 'Account successfully verified.'
            ];
            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function resendActivationCode()
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserCodeResend();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $user = $this->_user->_getUserWithEmail($this->email);
            if (!$user) {
                $response = [
                    'error' => true,
                    'message' => 'This email is not registered on our system.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            $userId = $user->id;
            $phone = $user->phone;

            // check if user is activated already
            if ($user->is_verified == env('STATUS_ACTIVE')) {
                $response = [
                    'error' => true,
                    'message' => 'Your account is already activated.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            // generate code if user is not activated
            $code = Helper::generateCode();
            $codeData = [
                'code' => $code,
                'expiry' => date("Y-m-d H:i:s", strtotime('+24 hours')),
                'is_expired' => 0
            ];
            // save code
            $this->_code->_update($userId, $codeData);
            // send sms to user with code
            $message = "Your new verification code is " . $code . " Thank you.";
            Helper::sendSMS($phone, urlencode($message));

            $response = [
                'message' => 'Verification code resent successfully',
                'email' => $this->email
            ];
            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function resetPassword()
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserCodeResend();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $user = $this->_user->_getUserWithEmail($this->email);
            if (!$user) {
                $response = [
                    'error' => true,
                    'message' => 'This email is not registered on our system.'
                ];
                return ['response' => $response, 'code' => 400];
            }
            $userId = $user->id;
            $phone = $user->phone;

            // Generate new password
            $password = Helper::generateRandomPassword();
            $payload = ['password' => Hash::make($password)];

            $this->_user->_update($userId, $payload);
            $message = "Your new password is " . $password . " Thank you.";
            Helper::sendSMS($phone, urlencode($message));

            $response = [
                'message' => 'Password reset successfully'
            ];
            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserPassword();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $user = $request->user();

            // check if old password really exist
            if (!Hash::check($this->oldPassword, $user->password)) {
                $response = [
                    'success' => false,
                    'description' => [
                        'message' => 'Old password is incorrect'
                    ]
                ];
                return ['response' => $response, 'code' => 400];
            }

            // save new password
            $this->_user->_update($user->id, ['password' => Hash::make($this->password)]);

            $response = [
                'message' => 'Password successfully updated'
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function updateUserProfile(Request $request)
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserProfile();
        if ($validation !== true) {
            return $validation;
        }

        try {

            $avatar = Helper::generateGravatar($this->email);
            // save user input
            $user = [
                'email' => $this->email,
                'phone' => $this->phone,
                'name' => $this->name,
                'avatar' => $avatar,
                'updated_at' => Carbon::now()
            ];
            $userId = $request->user()->id;
            $this->_user->_update($userId, $user);

            $user = $this->_user->_getUser($userId);

            $response = [
                'auth' => [
                    'college_id' => $user->college_id,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'name' => $user->name,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ]
            ];
            return ['response' => $response, 'code' => 200];
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function revokeOrGrantUserAccess($type)
    {
        try {
            // revoke user access
            $this->_user->_update($this->userId, ['is_revoke' => $this->isRevoked]);

            $response = [
                'message' => 'User access ' . $type . ' successfully',
                'users' => $this->_user->_getUsersWithParentId($this->parentId)
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function createUser(Request $request)
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserProfile();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $checkEmail = $this->_user->_checkEmailExistence($this->email);
            $checkPhone = $this->_user->_checkPhoneExistence($this->phone);
            if ($checkEmail) {
                $response = [
                    'error' => true,
                    'message' => 'Email ' . $this->email . ' already exists',
                ];
                return ['response' => $response, 'code' => 400];
            }
            if ($checkPhone) {
                $response = [
                    'error' => true,
                    'message' => 'Phone number ' . $this->phone . ' already exists',
                ];
                return ['response' => $response, 'code' => 400];
            }

            $user = $request->user();
            // generate random password
            $password = Helper::generateRandomPassword();

            // save user
            $payload = [
                'college_id' => $user->college_id,
                'parent_id' => $user->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_verified' => $this->isVerified,
                'role' => $this->role,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($password),
                'avatar' => Helper::generateGravatar($this->email),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $this->_user->_save($payload);

            $message = "Your email is " . $this->email . " and password is " . $password . ". Thank you.";
            Helper::sendSMS($this->phone, urlencode($message));

            $response = [
                'message' => 'User successfully added',
            ];

            return ['response' => $response, 'code' => 201];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function updateUser(Request $request)
    {
        $this->_validation = new VUser($this);
        // Validate user inputs
        $validation = $this->_validation->__validateUserProfile();
        if ($validation !== true) {
            return $validation;
        }

        try {
            $user = $request->user();

            // update user
            $payload = [
                'college_id' => $user->college_id,
                'parent_id' => $user->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'avatar' => Helper::generateGravatar($this->email),
                'updated_at' => Carbon::now()
            ];
            $this->_user->_update($this->userId, $payload);

            $response = [
                'message' => 'User successfully updated',
                'users' => $this->_user->_getUsersWithParentId($request->user()->id)
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getUsers(Request $request)
    {
        try {
            // obtain the parent id which is also the admin id
            $parentId = $request->user()->id;

            $users = $this->_user->_getUsersWithParentId($parentId);
            if ($users->isEmpty()) {
                $response = [
                    'error' => true,
                    'message' => 'You have not added any user',
                ];
                return ['response' => $response, 'code' => 404];
            }

            $response = [
                'users' => $users
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

    public function getUser()
    {
        try {
            $user = $this->_user->_getUser($this->userId);

            if (!$user) {
                $response = [
                    'error' => true,
                    'message' => 'No record found'
                ];
                return ['response' => $response, 'code' => 404];
            }

            $response = [
                'user' => $user
            ];

            return ['response' => $response, 'code' => 200];

        } catch (\Exception $e) {
            exit($e->getMessage());
        }
    }

}
