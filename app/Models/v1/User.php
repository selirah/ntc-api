<?php

namespace App\Models\v1;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    private $_connection;
    protected $table = 'users';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->_connection = DB::connection('mysql');
    }

    private function _connectTable()
    {
        $table = $this->_connection->table($this->table);
        return $table;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'api_token'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    public function _checkEmailExistence($email)
    {
        $query = $this->_connectTable()->where('email', '=', $email)->first();
        return ($query) ? true : false;
    }

    public function _checkPhoneExistence($phone)
    {
        $query = $this->_connectTable()->where('phone', '=', $phone)->first();
        return ($query) ? true : false;
    }

    public function _checkActivation($userId, $isVerified = 1)
    {
        $query = $this->_connectTable()->where('id', '=', $userId)
            ->where('is_verified', '=', $isVerified)->first();
        return ($query) ? true : false;
    }

    public function _save(array $payload)
    {
        $userId = $this->_connectTable()->insertGetId($payload);
        return $userId;
    }

    public function _update($userId, array $payload)
    {
        $this->_connectTable()->where('id', '=', $userId)->update($payload);
    }

    public function _updateMultiple(array $ids, array $payload)
    {
        $this->_connectTable()->whereIn('id', $ids)->update($payload);
    }

    public function _getUser($userId)
    {
        $query = $this->_connectTable()->where('id', '=', $userId)->first();
        return $query;
    }

    public function _getUserWithEmail($email)
    {
        $query = $this->_connectTable()->where('email', '=', $email)->first();
        return $query;
    }

    public function _getUserWithPhone($phone)
    {
        $query = $this->_connectTable()->where('phone', '=', $phone)->first();
        return $query;
    }

    public function _authenticateUser($userId, $isVerified, $isRevoked)
    {
        $query = $this->_connectTable()
            ->where('id', '=', $userId)
            ->where('is_verified', '=', $isVerified)
            ->where('is_revoke', '=', $isRevoked)
            ->first();
        return $query;
    }

    public function _getUserWithApiToken($apiToken, $time)
    {
        $query = $this->_connectTable()
            ->where('api_token', '=', $apiToken)
            ->where('token_expiry', '>', $time)
            ->first();
        return $query;
    }

    public function _getUsersWithParentId($parentId)
    {
        $query = $this->_connectTable()->where('parent_id', '=', $parentId)->get();
        return $query;
    }

}
