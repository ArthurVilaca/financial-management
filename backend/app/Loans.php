<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Loans extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'interest',
        'admin_taxes',
        'value_plots',
        'due_date',
        'issue_date',
        'banks_id',
    ];

}
