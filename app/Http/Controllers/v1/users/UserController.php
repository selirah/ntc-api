<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/17/2019
 * Time: 3:42 PM
 */

namespace App\Http\Controllers;

use App\Operations\v1\UserOperation;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $_user;

    public function __construct(UserOperation $userOperation)
    {
        $this->_user = $userOperation;
    }

    // @route  POST api/v1/auth/sign-up
    // @desc   Register user
    // @access Public
    public function register(Request $request)
    {
        // Declare variables
        $this->_user->name = trim($request->input('name'));
        $this->_user->email = trim($request->input('email'));
        $this->_user->phone = trim($request->input('phone'));
        $this->_user->password = trim($request->input('password'));
        $this->_user->confirmPass = trim($request->input('confirm_password'));
        $this->_user->hasAgreed = trim($request->input('agree'));

        // Register user
        $response = $this->_user->registerUser();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/account-verification
    // @desc   Verify user account
    // @access Public
    public function accountVerification(Request $request)
    {
        // Declare variables
        $this->_user->email = trim($request->input('email'));
        $this->_user->code = trim($request->input('code'));

        // Verify user account
        $response = $this->_user->activateUser();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/resend-code
    // @desc   Resent verification code
    // @access Public
    public function resendCode(Request $request)
    {
        $this->_user->email = trim($request->input('email'));
        $response = $this->_user->resendActivationCode();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/reset-password
    // @desc   Reset user password
    // @access Public
    public function resetPassword(Request $request)
    {
        $this->_user->email = trim($request->input('email'));
        $response = $this->_user->resetPassword();
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/login
    // @desc   Log user in
    // @access Public
    public function login(Request $request)
    {
        if (filter_var(trim($request->input('param')), FILTER_VALIDATE_EMAIL)) {
            $this->_user->loginType = env('LOGIN_EMAIL');
            $this->_user->loginParam = trim($request->input('param'));
        } else {
            $this->_user->loginType = env('LOGIN_PHONE');
            $this->_user->loginParam = trim($request->input('param'));
        }

        $this->_user->password = trim($request->input('password'));
        $this->_user->isVerified = env('STATUS_ACTIVE');
        $this->_user->isRevoked = env('NOT_REVOKE');
        $response = $this->_user->loginUser($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/auth/logout
    // @desc   Log user out
    // @access Private
    public function logout(Request $request)
    {
        $response = $this->_user->logoutUser($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/profile
    // @desc   Update profile
    // @access Private
    public function updateProfile(Request $request)
    {
        $this->_user->name = trim($request->input('name'));
        $this->_user->email = trim($request->input('email'));
        $this->_user->phone = trim($request->input('phone'));
        $response = $this->_user->updateUserProfile($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/auth/change-password
    // @desc   Change Password
    // @access Private
    public function changePassword(Request $request)
    {
        $this->_user->oldPassword = trim($request->input('old_password'));
        $this->_user->password = trim($request->input('new_password'));
        $this->_user->confirmPass = trim($request->input('confirm_password'));
        $response = $this->_user->changePassword($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  POST api/v1/users
    // @desc   Post User
    // @access Private
    public function createUser(Request $request)
    {
        $this->_user->name = trim($request->input('name'));
        $this->_user->email = trim($request->input('email'));
        $this->_user->phone = trim($request->input('phone'));
        $this->_user->isVerified = env('STATUS_ACTIVE');
        $this->_user->role = env('ROLE_USER');
        $response = $this->_user->createUser($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  PUT api/v1/users/:user_id
    // @desc   Update User
    // @access Private
    public function updateUser($userId, Request $request)
    {
        $this->_user->name = trim($request->input('name'));
        $this->_user->email = trim($request->input('email'));
        $this->_user->phone = trim($request->input('phone'));
        $this->_user->userId = $userId;
        $response = $this->_user->updateUser($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/users
    // @desc   Get User
    // @access Private
    public function getUsers(Request $request)
    {
        $response = $this->_user->getUsers($request);
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/users/:id
    // @desc   Get User
    // @access Private
    public function getUser($id)
    {
        $this->_user->userId = $id;
        $response = $this->_user->getUser();
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/users/revoke-user-access/:user_id
    // @desc   Revoke User Access
    // @access Private
    public function revokeUserAccess($id, Request $request)
    {
        $this->_user->userId = $id;
        $this->_user->isRevoked = env('REVOKE');
        $this->_user->parentId = $request->user()->id;
        $response = $this->_user->revokeOrGrantUserAccess('revoked');
        return response()->json($response['response'], $response['code']);
    }

    // @route  GET api/v1/users/grant-user-access/:user_id
    // @desc   Grant User Access
    // @access Private
    public function grantUserAccess($id, Request $request)
    {
        $this->_user->userId = $id;
        $this->_user->isRevoked = env('NOT_REVOKE');
        $this->_user->parentId = $request->user()->id;
        $response = $this->_user->revokeOrGrantUserAccess('granted');
        return response()->json($response['response'], $response['code']);
    }

}
