<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Employees extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'name', 
        'password', 
        'phone',
        'email',
        'adress',
        'adress_number',
        'adress_complement',
        'adress_district',
        'zip_code',
        'city',
        'state',
        'sector',
        'admission',
        'resignation',
        'salary',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'ip',
        'token',
        'expiration_date',
    ];

    public function findUserByEmail($email) {
        $user = DB::table('employees')
            ->where('email', $email)
            ->first();
        return $user;
    }

    public function findUserByToken($token) {
        $user = DB::table('employees')
            ->where('token', $token)
            ->first();
        return $user;
    }
}
