<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billspays extends Model
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
        'payment_date',
        'invoice_number',
        'invoice_date',
        'banks_id',
        'cost_centers_id',
        'discounts',
        'additions',
        'numberInstallments',
        'cost_centers_id'
    ];

    public function findByProject($id) {
        $phases = DB::table('billspays')
            ->join('projects_phases', 'projects_phases.id', '=', 'billspays.projects_phases_id')
            ->where('billspays.projects_phases_id', $id)
            ->get();

        return $phases;
    }

    public function convertDate($request){
        var_dump($request);die;
        $request = new \DateTime($request);
        $request = $request->format('Y-m-d H:i:s');

        return $request;
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

        $phases = DB::table('billspays')
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

        $phases = DB::table('billspays')
            ->where($where)
            ->count();

        return $phases;
    }

    public function loadAlerts() {
        $dataset = [];
        $where = [];

        $where[] = [
            'due_date', '=', (new \DateTime())->format('Y-m-d')
        ];

        $bills = DB::table('billspays')
            ->where($where)
            ->count();

        $amount = DB::table('billspays')
            ->where($where)
            ->sum('billspays.amount');

        $dataset[] = [
            'msg' => 'Contas vencendo hoje: '.$bills.' no total de R$ '.number_format($amount, 2)
        ];
        return $dataset;
    }

    public function getReport($filter) {
        $phases = DB::table('cost_centers')
            ->get();    

        foreach ($phases as $key => $value) {

            $value->bills = DB::table('billspays')
                ->where('billspays.cost_centers_id', $value->id)
                ->count();

            $value->amount = DB::table('billspays')
                ->where('billspays.cost_centers_id', $value->id)
                ->sum('billspays.amount');
        }

        return $phases;
    }
}
