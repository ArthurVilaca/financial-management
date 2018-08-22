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
        'projects_id',
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
        $orWhere = [];
        if( isset($filters['date_from']) ) {
            $where[] = [
                'billspays.created_at', '>', $filters['date_from']
            ];
        }
        if( isset($filters['date_to']) ) {
            $where[] = [
                'billspays.created_at', '<', $filters['date_to']
            ];
        }
        if( isset($filters['due_from']) ) {
            $where[] = [
                'billspays.due_date', '>', $filters['due_from']
            ];
        }
        if( isset($filters['due_to']) ) {
            $where[] = [
                'billspays.due_date', '<', $filters['due_to']
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'billspays.status', '=', $filters['status']
            ];
        }
        if( isset($filters['project_id']) ) {
            $where[] = [
                'projects_id', '=', $filters['project_id']
            ];
        }
        if( isset($filters['clients_id']) ) {
            $where[] = [
                'projects.clients_id', '=', $filters['clients_id']
            ];
        }
        if( isset($filters['searchWords']) ) {
            $orWhere = [
                // [ 'clients.name', 'like', '%'.$filters['searchWords'].'%' ],
                // [ 'billspays.status', 'like', '%'.$filters['searchWords'].'%' ],
                [ 'billspays.comments', 'like', '%'.$filters['searchWords'].'%' ]
            ];
        }

        $where[] = [
            'billspays.type', '<>', 'DEDUCOES'
        ];

        $phases = DB::table('billspays')
            ->select('billspays.*', 'projects.clients_id')
            ->join('projects', 'projects.id', '=', 'billspays.projects_id')
            ->join('clients', 'clients.id', '=', 'projects.clients_id')
            ->where($where)
            ->orWhere($orWhere)
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function count($filters) {
        $where = [];
        $orWhere = [];
        if( isset($filters['date_from']) ) {
            $where[] = [
                'billspays.created_at', '>', $filters['date_from']
            ];
        }
        if( isset($filters['date_to']) ) {
            $where[] = [
                'billspays.created_at', '<', $filters['date_to']
            ];
        }
        if( isset($filters['due_from']) ) {
            $where[] = [
                'billspays.due_date', '>', $filters['due_from']
            ];
        }
        if( isset($filters['due_to']) ) {
            $where[] = [
                'billspays.due_date', '<', $filters['due_to']
            ];
        }
        if( isset($filters['status']) ) {
            $where[] = [
                'billspays.status', '=', $filters['status']
            ];
        }
        if( isset($filters['project_id']) ) {
            $where[] = [
                'projects_id', '=', $filters['project_id']
            ];
        }
        if( isset($filters['clients_id']) ) {
            $where[] = [
                'projects.clients_id', '=', $filters['clients_id']
            ];
        }
        if( isset($filters['searchWords']) ) {
            $orWhere = [
                // [ 'clients.name', 'like', '%'.$filters['searchWords'].'%' ],
                // [ 'billspays.status', 'like', '%'.$filters['searchWords'].'%' ],
                [ 'billspays.comments', 'like', '%'.$filters['searchWords'].'%' ]
            ];
        }

        $where[] = [
            'billspays.type', '<>', 'DEDUCOES'
        ];

        $phases = DB::table('billspays')
            ->join('projects', 'projects.id', '=', 'billspays.projects_id')
            ->join('clients', 'clients.id', '=', 'projects.clients_id')
            ->where($where)
            ->orWhere($orWhere)
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
