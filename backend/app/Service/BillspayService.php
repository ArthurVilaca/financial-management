<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Billspay;

class BillspayService extends Service
{
    private $billspay;

    public function __construct()
    {
        $this->billspay = new Billspay();
    }

    public function create(Request $request)
    {
        $returnBillspay = $this->billspay->create([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'comments' => $request->get('comments'),
            'amount' => $request->get('amount'),
            'projects_phases_id' => $request->get('projects_phases_id'),
        ]);

        return $returnBillspay;
    }

}
?>