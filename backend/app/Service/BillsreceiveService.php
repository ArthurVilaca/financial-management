<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Billsreceives;
use App\Billspays;

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
            'comments' => $request->get('comments'),
            'status' => $request->get('status'),
            'type' => $request->get('type'),	
            'amount' => $request->get('amount'),
            'due_date' => $request->get('due_date'),
            'payment_date' => new \DateTime($request->get('payment_date')),
            'invoice_number' => $request->get('invoice_number'),
            'invoice_date' => new \DateTime($request->get('invoice_date')),
            'banks_id' => $request->get('banks_id'),
            'projects_id' => $request->get('projects_id'),
        ]);

        return $returnBill;
    }

    public function generateInvoice($request){
        $idProject =  $this->billsreceives->getProjectInvoice($request);
        
        if($idProject){
            foreach ($idProject as $key => $value) {
                $projectName = $value->ProjectName;
                $phaseAmount = $value->phaseAmount; 
                $phaseId = $value->idProjectPhase;
                
                $providerTax = $this->billsreceives->getProviderTax($value->phaseProviderId);
                $installmentNumber = intval ($value->installmentNumber);
                
                $date = new \DateTime();

                if($providerTax){                    
                    foreach ($providerTax as $key => $value){
                        
                        $provider_name = $value->providerName;
                        $numberAmount = 0;
                        $numberAmount = $phaseAmount * ($value->TaxAmount / 100);     
                        for ($i=0; $i < $installmentNumber ; $i++) {  
                            $this->billspays->create([
                                'name' => 'Conta a Pagar referente ao imposto'. $value->TaxName 
                                .' referente ao projeto '.$projectName. 'e ao fornecedor '.$provider_name,
                                'status' => 'Prevista',
                                'comments' => 'Conta gerada por nota fiscal. ',
                                'amount' => number_format($numberAmount / $installmentNumber, 2),
                                //'projects_phases_id' => $phaseId,
                                'due_date' => $date,
                            ]);
                            $date->modify('+30 day');
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

    public function getRecipes(){

        $recipes = $this->billsreceives->getRecipes();
        return $recipes;
    }

    public function loadDeductions($billsreceive_id) {
        $deductions = $this->billsreceives->loadDeductions($billsreceive_id);
        return $deductions;
    }
}
?>