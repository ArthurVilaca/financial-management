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
        $this->billspays = new Billspays();
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

    public function generateInvoice($request){
        $idProject =  $this->billsreceives->getProjectInvoice($request);
        var_dump($idProject);die;
        if($idProject){
            //$phaseProject = $this->billsreceives->getPhaseProject($idProject);           
            if($phaseProject){

                foreach ($phaseProject as $key => $value) {
                    $providerTaxes = $this->billsreceives->getProviderTax($value->providers_id);
                    if($providerTaxes){
                        foreach ($providerTaxes as $key => $value) {
                            $number = $value->number;
                            $numberCost = $value->amount / $number;
                            foreach ($number as $key => $value) {

                                $this->billspays->create([
                                    'name' => 'Nota fiscal N° '. $$request->invoive_number .' referente ao projeto '.$request->name. 'e ao fornecedor'.$provider_name,
                                    'status' => 'Prevista',
                                    'comments' => 'Taxa referente ao imposto '. $tax->name .' e ao projeto '.$request->get('name'). 'e ao fornecedor'.$provider_name,
                                    'amount' => $valueTax,
                                    'projects_phases_id' => $returnPhase->id,
                                    'due_date' => $date,
                                ]);
                                
                            }
                        }                        
                    }
                
                }

            }            
        }
    }

    public function load($page, $pageSize, $filters)
    {
        $returnBill = $this->billsreceives->loadBills($page, $pageSize, $filters);

        return $returnBill;
    }

    public function count($filters)
    {
        $countBills = $this->billsreceives->count($filters);

        return $countBills;
    }

}
?>