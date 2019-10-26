<?php
/**
 * Created by PhpStorm.
 * User: selirah
 * Date: 10/17/2019
 * Time: 3:53 PM
 */

namespace App\Interfaces\v1;

use Illuminate\Http\Request;


interface UserInterface
{
    public function registerUser();

    public function loginUser(Request $request);

    public function activateUser();

    public function resendActivationCode();

    public function resetPassword();

    public function changePassword(Request $request);

    public function updateUserProfile(Request $request);

    public function revokeOrGrantUserAccess($type);

    public function createUser(Request $request);

    public function updateUser(Request $request);

    public function getUsers(Request $request);

    public function getUser();
}
