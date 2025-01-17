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

    public function loadProviders($page, $pageSize, $filters) {
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

        $phases = DB::table('providers')
            ->where($where)
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function getNameProvider($id){
        $provider = DB::table('providers')->select('name')->where('id','=', $id)->get();
        return $provider;
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

        $phases = DB::table('providers')
            ->where($where)
            ->count();

        return $phases;
    }
}
