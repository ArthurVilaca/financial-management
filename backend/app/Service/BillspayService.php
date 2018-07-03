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
            'projects_phases_id' => $request->get('projects_phases_id'),
        ]);

        return $returnBillspay;
    }

    public function load($page, $pageSize)
    {
        $returnBillspay = $this->billspays->loadBills($page, $pageSize);

        return $returnBillspay;
    }

    public function count()
    {
        $countBillspay = $this->billspays->count();

        return $countBillspay;
    }

}
?>