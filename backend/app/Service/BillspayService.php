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
        
        $returnBillspay = $this->billspays->create([
            'name' => $request->get('name'),
            'comments' => $request->get('comments'),
            'status' => $request->get('status'),
            'type' => $request->get('type'),
            'amount' => $request->get('amount'), 
            'due_date' => $request->get('due_date'),
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
        return $returnBillspay;
    }

    public function load($page, $pageSize, $filters)
    {
        var_dump($filters);die;
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