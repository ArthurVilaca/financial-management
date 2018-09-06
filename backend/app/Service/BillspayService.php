<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Billspays;

class BillspayService extends Service
{
    private $billspays;

    public function __construct()
    {
        $this->billspays = new Billspays();
    }

    public function create(Request $request)
    {
        $installments =  $request->get('numberInstallments');
        $date_update = new \DateTime($request->get('due_date'));         

        for ($i=0; $i < $installments; $i++) { 
            
            $valueInstallment = floatval($request->get('amount')) / $installments;
            $returnBillspay = $this->billspays->create([
                'name' => $i.'ª'.' parcela'. $request->get('name'),
                'comments' => $request->get('comments'),
                'status' => $request->get('status'),
                'type' => $request->get('type'),
                'amount' => $valueInstallment , 
                'due_date' => $date_update ,
                'payment_date' => new \DateTime($request->get('payment_date')),
                'banks_id' => $request->get('banks_id'),
                'cost_centers_id' => $request->get('cost_centers_id'),
                'projects_phases_id' => $request->get('projects_phases_id'),
                'projects_id' => $request->get('projects_id'),
                'providers_id' => $request->get('providers_id'),
                'numberInstallments' => $request->get('numberInstallments'),
                'invoice_number' => $request->get('invoice_number'),
                'invoice_date' => new \DateTime($request->get('invoice_date')),
            ]);             

            $date_update->modify('+1 month');

        }

        return $returnBillspay;
    }

    public function load($page, $pageSize, $filters)
    {
        $returnBillspay = $this->billspays->loadBills($page, $pageSize, $filters);

        return $returnBillspay;
    }

    public function count($filters)
    {
        $countBillspay = $this->billspays->count($filters);

        return $countBillspay;
    }

}
?>