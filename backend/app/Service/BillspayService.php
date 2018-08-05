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
            'status' => $request->get('status'),
            'comments' => $request->get('comments'),
            'amount' => $request->get('amount'), 
            'numberInstallments' => $request->get('numberInstallments'),
            'projects_phases_id' => $request->get('projects_phases_id'),
            'cost_centers_id' => $request->get('cost_centers_id'),
        ]);
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