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

    public function loadProjects($page, $pageSize,$filters) {

        $where = [];
        if( isset($filters['date_from']) ) {
            $where[] = [
                'created_at', '>', $filters['date_from']
            ];
        }
        if( isset($filters['date_to']) ) {
            $where[] = [
                'created_at', '<', $filters['date_to']
            ];
        }
        if( isset($filters['name']) ) {
            $where[] = [
                'name', 'like', '%'.$filters['name'].'%'
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'status', '=', $filters['status']
            ];
        }

        $phases = DB::table('projects')
            ->where($where)
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function count($filters) {
        $where = [];
        if( isset($filters['date_from']) ) {
            $where[] = [
                'created_at', '>', $filters['date_from']
            ];
        }
        if( isset($filters['date_to']) ) {
            $where[] = [
                'created_at', '<', $filters['date_to']
            ];
        }
        if( isset($filters['name']) ) {
            $where[] = [
                'name', 'like', '%'.$filters['name'].'%'
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'status', '=', $filters['status']
            ];
        }

        $phases = DB::table('projects')
            ->where($where)
            ->count();

        return $phases;
    }
}
