<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Taxes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'type',
        'reference',
        'description',
        'collection',
    ];

    public function loadProvider($id) {
        $client = DB::table('provider_taxes')
            ->join('taxes', 'taxes.id', '=', 'provider_taxes.taxes_id')
            ->where('provider_taxes.providers_id', $id)
            ->get();
        
        return $client;
    }

    public function loadClient($id) {
        $client = DB::table('client_taxes')
            ->join('taxes', 'taxes.id', '=', 'client_taxes.taxes_id')
            ->where('client_taxes.clients_id', $id)
            ->get();
        
        return $client;
    }
}
