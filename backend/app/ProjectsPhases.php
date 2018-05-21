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
        'expiration_date',
        'projects_id',
    ];

}
