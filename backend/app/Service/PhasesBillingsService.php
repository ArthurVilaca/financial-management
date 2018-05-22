<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\PhasesBillings;

class PhasesBillingsService extends Service
{
    private $phasesBillings;

    public function __construct()
    {
        $this->phasesBillings = new PhasesBillings();
    }

    public function create(Request $request)
    {
        $returnTax = $this->phasesBillings->create([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'amount' => $request->get('amount'),
            'due_date' => $request->get('due_date'),
            'projects_phases_id' => $request->get('projects_phases_id'),
        ]);

        return $returnTax;
    }

}
?>