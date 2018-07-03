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
    ];

    public function findByProject($id) {
        $phases = DB::table('billspays')
            ->join('projects_phases', 'projects_phases.id', '=', 'billspays.projects_phases_id')
            ->where('billspays.projects_phases_id', $id)
            ->get();

        return $phases;
    }

    public function loadBills($page, $pageSize) {
        $phases = DB::table('billspays')
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function count() {
        $phases = DB::table('billspays')
            ->count();

        return $phases;
    }
}
