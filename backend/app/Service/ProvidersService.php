<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Providers;

class ProvidersService extends Service
{
    private $providers;

    public function __construct()
    {
        $this->providers = new Providers();
    }

    public function create(Request $request)
    {
        $returnClient = $this->providers->create([
            'name' => $request->get('name'),
        ]);

        return $returnClient;
    }

}
?>