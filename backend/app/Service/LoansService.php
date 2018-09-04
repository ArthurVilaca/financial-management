<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Loans;

class LoansService extends Service
{
    private $loans;

    public function __construct()
    {
        $this->loans = new Loans();
    }

    public function create(Request $request)
    {
        $returnPhase = $this->loans->create([
            'amount' => $request->get('amount'),
            'interest' => $request->get('interest'),
            'admin_taxes' => $request->get('admin_taxes'),
            'value_plots' => $request->get('value_plots'),
            'due_date' => new \DateTime($request->get('due_date')),
            'issue_date' => new \DateTime(),
            'banks_id' => $request->get('banks_id'),
        ]);

        return $returnPhase;
    }

}
?>