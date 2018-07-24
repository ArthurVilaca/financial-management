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
        'sunday_in',
        'sunday_out',
        'monday_in',
        'monday_out',
        'tuesday_in',
        'tuesday_out',
        'wednesday_in',
        'wednesday_out',
        'thursday_in',
        'thursday_out',
        'friday_in',
        'friday_out',
        'saturday_in',
        'saturday_out',
        'use_time_control',
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

    public function load($filters) {
        $where = [];
        if( isset($filters['name']) ) {
            $where[] = [
                'name', 'like', '%'.$filters['name'].'%'
            ];
        }

        $user = DB::table('employees')
            ->where($where)
            ->get();
        return $user;
    }

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
