<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Billsreceives;

class BillsreceiveService extends Service
{
    private $billsreceives;

    public function __construct()
    {
        $this->billsreceives = new Billsreceives();
    }

    public function create(Request $request)
    {
        $returnBill = $this->billsreceives->create([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'comments' => $request->get('comments'),
            'amount' => $request->get('amount'),
            'projects_id' => $request->get('projects_id'),
        ]);

        return $returnBill;
    }

}
?>