<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billspay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'comments',
        'amount',
        'projects_phases_id',
        'due_date',
    ];

    public function findByProject($id) {
        $phases = DB::table('billspay')
            ->join('projects_phases', 'projects_phases.id', '=', 'billspay.projects_phases_id')
            ->where('billspay.projects_phases_id', $id)
            ->get();

        return $phases;
    }
}
