<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billsreceive extends Model
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
        'projects_id',
        'due_date',
    ];

    public function findByProject($id) {
        $phases = DB::table('billsreceive')
            ->join('projects', 'projects.id', '=', 'billsreceive.projects_id')
            ->where('billsreceive.projects_id', $id)
            ->get();

        return $phases;
    }
}
