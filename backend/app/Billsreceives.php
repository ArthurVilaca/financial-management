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

            $value->bills = DB::table('billsreceives')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->where($where)
                ->count();

            $value->amount = DB::table('billsreceives')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->where($where)
                ->sum('billsreceives.amount');
        }

        return $phases;
    }

    public function getRecipes(){

        $recipes = DB::table('cost_centers')->get();

        foreach ($recipes as $key => $value) {

            $now = new \DateTime();
            $lessOneYear = $now->modify('-12 month');

            $value->amountReceive = DB::table('billsreceives')
                ->where('billsreceives.cost_centers_id', $value->id)
                ->where('billsreceives.status','Efetuada')
                ->whereBetween('billsreceives.updated_at', [$lessOneYear, $now])
                ->count();

           
        }

        return $recipes;
    }
    
    public function getProjectInvoice($id){

        //$projectInvoice = DB::table('projects')->select('id')->where('id', $id)->first(); 
        $projectInvoice = DB::table('projects')
            ->join('projects_phases', 'projects.id', '=', 'projects_phases.projects_id')     
            ->select('projects.name AS  ProjectName', 'projects_phases.providers_id AS phaseProviderId',
            'projects_phases.amount AS phaseAmount', 'projects_phases.number AS installmentNumber', 
            'projects_phases.projects_id as idProjectPhase', 'projects_phases.expiration_date as expiration_date ')
            ->where('projects.id',$id)
            ->get();

        return $projectInvoice;
    }

    public function getProviderTax($id){
        
        $providerTaxes = DB::table('providers')
            ->join('provider_taxes', 'providers.id', '=', 'provider_taxes.providers_id')
            ->join('taxes', 'provider_taxes.taxes_id', '=', 'taxes.id')
            ->select( 'taxes.name AS TaxName','taxes.amount AS TaxAmount', 'providers.name as providerName')->where('providers.id',$id)
            ->get();
        
        return $providerTaxes;
    }
}
