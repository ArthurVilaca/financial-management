<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Providers;
use App\Taxes;

class ProvidersService extends Service
{
    private $providers;
    private $taxes;

    public function __construct()
    {
        $this->providers = new Providers();
        $this->taxes = new Taxes();
    }

    public function create(Request $request)
    {
        $returnClient = $this->providers->create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'adress' => $request->get('adress'),
            'adress_number' => $request->get('adress_number'),
            'adress_complement' => $request->get('adress_complement'),
            'adress_district' => $request->get('adress_district'),
            'zip_code' => $request->get('zip_code'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
        ]);

        return $returnClient;
    }

    public function loadTaxes($id) {
        $taxes = $this->taxes->loadProvider($id);
        return $taxes;
    }

}
?>