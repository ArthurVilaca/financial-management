<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Clients;
use App\Taxes;

class ClientsService extends Service
{
    private $clients;
    private $taxes;

    public function __construct()
    {
        $this->clients = new Clients();
        $this->taxes = new Taxes();
    }

    public function create(Request $request)
    {
        $returnClient = $this->clients->create([
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
        $taxes = $this->taxes->loadClient($id);
        return $taxes;
    }

    public function load($page, $pageSize)
    {
        $returnClients = $this->clients->loadClients($page, $pageSize);

        return $returnClients;
    }

    public function count()
    {
        $countClients = $this->clients->count();

        return $countClients;
    }

}
?>