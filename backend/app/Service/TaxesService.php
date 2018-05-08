<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Taxes;

class TaxesService extends Service
{
    private $taxes;

    public function __construct()
    {
        $this->taxes = new Taxes();
    }

    public function create(Request $request)
    {
        $returnTax = $this->taxes->create([
            'name' => $request->get('name'),
            'amount' => $request->get('amount'),
        ]);

        return $returnTax;
    }

}
?>