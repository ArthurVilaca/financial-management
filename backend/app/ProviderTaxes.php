<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProviderTaxes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'providers_id', 
        'taxes_id', 
    ];

    public function loadByProvider($id) {
        $providerTaxes = DB::table('provider_taxes')
            ->join('taxes', 'taxes.id', '=', 'provider_taxes.taxes_id')
            ->where('providers_id', $id)
            ->get();
        return $providerTaxes;
    }
}
