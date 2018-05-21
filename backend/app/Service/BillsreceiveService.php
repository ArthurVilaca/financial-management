<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Billsreceive;

class BillsreceiveService extends Service
{
    private $billsreceive;

    public function __construct()
    {
        $this->billsreceive = new Billsreceive();
    }

    public function create(Request $request)
    {
        $returnBill = $this->billsreceive->create([
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