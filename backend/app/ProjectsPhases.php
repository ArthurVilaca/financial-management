<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProjectsPhases extends Model
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
        'expiration_date',
        'amount',
        'number',
        'projects_id',
        'providers_id',
    ];

    public function findByProject($id) {
        $phases = DB::table('projects_phases')
            ->join('projects', 'projects.id', '=', 'projects_phases.projects_id')
            ->where('projects_phases.providers_id', $id)
            ->get();
        
        return $phases;
    }
}
