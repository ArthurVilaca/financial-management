<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\PaymentMethods;

class PaymentMethodsService extends Service
{
    private $paymentMethods;

    public function __construct()
    {
        $this->paymentMethods = new PaymentMethods();
    }

    public function create(Request $request)
    {
        $returnData = $this->paymentMethods->create([
            'name' => $request->get('name'),
        ]);

        return $returnData;
    }

}
?>