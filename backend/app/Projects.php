<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Projects extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'status',
        'amount',
        'clients_id',
        'expiration_date',
        'banks_id',
        'number',
    ];

    public function loadProjects($page, $pageSize) {
        $phases = DB::table('projects')
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function count() {
        $phases = DB::table('projects')
            ->count();

        return $phases;
    }
}
