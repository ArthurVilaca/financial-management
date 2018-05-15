<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Taxes;
use App\ClientTaxes;
use App\ProviderTaxes;

class TaxesService extends Service
{
    private $taxes;
    private $clientTaxes;
    private $providerTaxes;

    public function __construct()
    {
        $this->taxes = new Taxes();
        $this->clientTaxes = new ClientTaxes();
        $this->providerTaxes = new ProviderTaxes();
    }

    public function create(Request $request)
    {
        $returnTax = $this->taxes->create([
            'name' => $request->get('name'),
            'amount' => $request->get('amount'),
            'reference' => $request->get('reference'),
            'description' => $request->get('description'),
            'collection' => $request->get('collection'),
            'type' => $request->get('type'),
        ]);

        return $returnTax;
    }

    public function createProvider(Request $request, $provider_id) {
        $returnTax = $this->providerTaxes->create([
            'providers_id' => $provider_id,
            'taxes_id' => $request->get('id'),
        ]);

        return $returnTax;
    }

    public function createClient(Request $request, $client_id) {
        $returnTax = $this->clientTaxes->create([
            'clients_id' => $client_id,
            'taxes_id' => $request->get('id'),
        ]);

        return $returnTax;
    }

}
?>