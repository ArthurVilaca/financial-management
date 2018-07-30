<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billsreceives extends Model
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
        'payment_date',
        'invoice_number',
        'invoice_date',
        'banks_id',
        'cost_centers_id',
        'discounts',
        'additions',
    ];

    public function findByProject($id) {
        $phases = DB::table('billsreceives')
            ->join('projects', 'projects.id', '=', 'billsreceives.projects_id')
            ->where('billsreceives.projects_id', $id)
            ->get();

        return $phases;
    }

    public function loadBills($page, $pageSize, $filters) {
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
        if( isset($filters['due_from']) ) {
            $where[] = [
                'due_date', '>', $filters['due_from']
            ];
        }
        if( isset($filters['due_to']) ) {
            $where[] = [
                'due_date', '<', $filters['due_to']
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'status', '=', $filters['status']
            ];
        }

        $phases = DB::table('billsreceives')
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
        if( isset($filters['due_from']) ) {
            $where[] = [
                'due_date', '>', $filters['due_from']
            ];
        }
        if( isset($filters['due_to']) ) {
            $where[] = [
                'due_date', '<', $filters['due_to']
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'status', '=', $filters['status']
            ];
        }

        $phases = DB::table('billsreceives')
            ->where($where)
            ->count();

        return $phases;
    }

    public function getReport($filter) {
        $phases = DB::table('cost_centers')
            ->get();    

        foreach ($phases as $key => $value) {

            $value->bills = DB::table('billsreceives')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->count();

            $value->amount = DB::table('billsreceives')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->sum('billsreceives.amount');
        }

        return $phases;
    }
}
