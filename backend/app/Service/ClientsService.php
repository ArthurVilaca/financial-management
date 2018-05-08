<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Clients;

class ClientsService extends Service
{
    private $clients;

    public function __construct()
    {
        $this->clients = new Clients();
    }

    public function create(Request $request)
    {
        $returnClient = $this->clients->create([
            'name' => $request->get('name'),
        ]);

        return $returnClient;
    }

}
?>