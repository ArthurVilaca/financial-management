<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Providers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'status', 
        'phone',
        'email',
        'adress',
        'adress_number',
        'adress_complement',
        'adress_district',
        'zip_code',
        'city',
        'state',
    ];

    public function loadProviders($page, $pageSize) {
        $phases = DB::table('providers')
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function count() {
        $phases = DB::table('providers')
            ->count();

        return $phases;
    }
}
