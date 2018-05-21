<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProjectsProviders extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projects_id',
        'providers_id',
    ];

}
