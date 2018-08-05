<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CostCenters extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

    public function newProject() {
        $costCenter = DB::table('cost_centers')
            ->where('name', 'Receita de projeto')
            ->first();
        return $costCenter;
    }

    public function loadCostCenters($page, $pageSize) {
        $phases = DB::table('cost_centers')
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return $phases;
    }

    public function loadCostCentersFilters($page, $pageSize,$filters) {
        $phases = DB::table('cost_centers')->where('type', '=', $filters)->get();

        return $phases;
    }

    public function count() {
        $phases = DB::table('cost_centers')
            ->count();

        return $phases;
    }
}
