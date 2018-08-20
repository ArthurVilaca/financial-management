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

    public function getReport($filters) {

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

        $phases = DB::table('cost_centers')
            ->get();    

        foreach ($phases as $key => $value) {

            
            /*$value->bills = DB::table('billspays')
                ->where('billspays.cost_centers_id', $value->id)

                ->count();*/
            $value->bills = DB::table('billspays')
            ->where('billspays.cost_centers_id', $value->id)
            ->where($where)
            ->count();

            $value->amount = DB::table('billspays')
                ->where('billspays.cost_centers_id', $value->id)
                ->where($where)
                ->sum('billspays.amount');
        }

        return $phases;
    }

    public function getExpenses($page, $pageSize){               


        $where = [];
        if( isset($filters['date_from']) ) {
            $where[] = [
                'created_at', '>', $filters['date_from']
            ];
        }

        $expenses = DB::table('cost_centers')
        ->offset($page * $pageSize)
        ->limit($pageSize)
        ->get(); 
        
        if($filters){




        }else{

            $now = new \DateTime();
            $lessOneYear = $now->modify('-12 month'); 

            $vectorPay = array();

            foreach ($expenses as $key => $value) {
                $now = new \DateTime();
                $lessOneYear = $now->modify('-12 month'); 
                
                $value->amountPay = DB::table('billspays')
                    ->where('billspays.status', 'Efetuada')
                    ->where('billspays.cost_centers_id', $value->id)
                    ->whereDate('created_at', '>' ,$lessOneYear->format('Y-m-d'))
                    ->whereDate('created_at', '<= ', $now->format('Y-m-d'))
                    //->whereBetween('billspays.updated_at', [$lessOneYear->format('Y-m-d H:i:s'), $now->format('Y-m-d H:i:s')])
                    ->sum('billspays.amount'); 

                $value->amountReceive = DB::table('billsreceives')
                ->where('billsreceives.status','Efetuada')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->whereDate('created_at', '>' ,$lessOneYear->format('Y-m-d'))
                ->whereDate('created_at', '<= ', $now->format('Y-m-d'))
                //->whereBetween('billsreceives.updated_at', [$lessOneYear->format('Y-m-d'), $now->format('Y-m-d')])
                ->sum('billsreceives.amount'); 

                $value->profit = $value->amountReceive - $value->amountPay;
            }
        }        
        return $expenses;        
    }
}
