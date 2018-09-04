<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Projects;
use App\ProjectsPhases;
use App\Billspays;
use App\Billsreceives;
use App\Providers;
use App\Taxes;
use App\CostCenters;
use App\ProviderTaxes;

class ProjectsService extends Service
{
    private $projects;
    private $projectsPhases;
    private $billspays;
    private $billsreceives;
    private $providers;
    private $taxes;
    private $costCenters;    
    private $providerTaxes;

    public function __construct()
    {
        $this->projects = new Projects();
        $this->projectsPhases = new ProjectsPhases();
        $this->billspays = new Billspays();
        $this->billsreceives = new Billsreceives();
        $this->providers = new Providers();
        $this->taxes = new Taxes();
        $this->costCenters = new CostCenters();
        $this->providerTaxes = new ProviderTaxes();
    }

    public function create(Request $request)
    {    
        $returnProject = $this->projects->create([
            'name' => $request->get('name'),
            'notes' => $request->get('notes'),
            'status' => $request->get('status'),
            'amount' => $request->get('amount'),
            'number' => $request->get('number'),
            'clients_id' => $request->get('clients_id'),
            'banks_id' => $request->get('banks_id'),
        ]);

        /*
        $returnProject['projects_phases'] = [];
        $projects_phases = $request->get('projects_phases');
        $i = 0;
        if(isset($projects_phases) || $projects_phases != '' ){
            foreach ($projects_phases as $key => $value) {
            
                // $date->add(new DateInterval('P'.$i.'D'));
     
                 $date = new \DateTime($value['expiration_date']);
                 $returnPhase = $this->projectsPhases->create([
                     'status' => $value['status'],
                     'comments' => $value['comments'],
                     'amount' => $value['amount'],
                     'number' => $value['number'],
                     'expiration_date' => $date,
                     'projects_id' => $returnProject->id,
                     'providers_id' => $value['providers_id']
                 ]);
     
                 //Contas a pagar referente a fornecedor
                 $id_provider = $value['providers_id'];
                 $provider_name = $this->providers->getNameProvider($id_provider);                        
     
                 $taxes = $this->providerTaxes->loadByProvider($value['providers_id']);
                 for($i = 0 ; $i < $value['number']; $i ++){
                     if(isset($taxes) && $taxes != ''){
                         foreach ($taxes as $tax) {
     
                             if($tax->collection == '%') {
                                 $valueTax = ($value['amount'] / 100) * $tax->amount;
                             } else {
                                 $valueTax = $tax->amount;
                             }
                             //$valueTax = ($valueTax - ($valueTax * $tax->amount));
     
                             $this->billspays->create([
                                 'name' => 'Taxa referente ao imposto '. $tax->name .' e ao projeto '.$request->get('name'). 'e ao fornecedor'.$provider_name,
                                 'status' => 'Prevista',
                                 'comments' => 'Taxa referente ao imposto '. $tax->name .' e ao projeto '.$request->get('name'). 'e ao fornecedor'.$provider_name,
                                 'amount' => $valueTax,
                                 'projects_phases_id' => $returnPhase->id,
                                 'due_date' => $date,
                             ]);
                             $date->modify('+1 month');
                        }
                     }else{
                         $valueTax = $value['amount'] / $value['number'];
                         $this->billspays->create([
                             'name' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                             'status' => 'Prevista',
                             'comments' => 'Conta referente ao fornecedor '.$provider_name.' - REF '.$date->format('Y-m'),
                             'amount' => $valueTax,
                             'projects_phases_id' => $returnPhase->id,
                             'due_date' => $date,
                         ]);
                         $date->modify('+1 month');
                     }                         
                 }
     
                 //////////// commented to wait for validation
                 // for ($i=0; $i < $value['number']; $i++) { 
                 //     $this->billspays->create([
                 //         'name' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                 //         'status' => 'Prevista',
                 //         'comments' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                 //         'amount' => $value['amount'],
                 //         'projects_phases_id' => $returnPhase->id,
                 //         'due_date' => $date,
                 //     ]);
     
                 //     $taxes = $this->providerTaxes->loadByProvider($value['providers_id']);
                 //     foreach ($taxes as $tax) {
     
                 //         if($tax->collection == '%') {
                 //             $valueTax = ($value['amount'] / 100) * $tax->amount;
                 //         } else {
                 //             $valueTax = $tax->amount;
                 //         }
                 //         $this->billspays->create([
                 //             'name' => 'Taxa referente ao imposto '. $tax->name .' e ao projeto '.$request->get('name'),
                 //             'status' => 'Prevista',
                 //             'comments' => 'Taxa referente ao imposto '. $tax->name .' e ao projeto '.$request->get('name'),
                 //             'amount' => $valueTax,
                 //             'projects_phases_id' => $returnPhase->id,
                 //             'due_date' => $date,
                 //         ]);
                 //     }
                 // }
             }

        }

        //Contas a receber o projeto cadastrado
        $costCenter = $this->costCenters->newProject();
        $date = new \DateTime();
        for ($i=0; $i < $request->get('number'); $i++) { 
            $portion = floatval( $request->get('amount') ) / intval($request->get('number'));
            
            $this->billsreceives->create([
                'name' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                'status' => 'Prevista',
                'comments' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                'amount' => $portion,
                'projects_id' => $returnProject->id,
                'due_date' => $date,
                'banks_id' => $request->get('banks_id'),
                'cost_centers_id' => $costCenter->id
            ]);
            $date->modify('+1 month');
        }
        */

        return $returnProject;
    }

    public function getProjectPhases($id) {
        $phases = $this->projectsPhases->findByProject($id);
        return $phases;
    }

    public function getProjectBillspay($id) {
        $billspays = $this->billspays->findByProject($id);
        return $billspays;
    }

    public function getProjectBillsreceive($id) {
        $billsreceives = $this->billsreceives->findByProject($id);
        return $billsreceives;
    }

    public function load($page, $pageSize, $filters)
    {
        $returnProject = $this->projects->loadProjects($page, $pageSize,$filters);

        return $returnProject;
    }

    public function count($filters)
    {
        $countProjects = $this->projects->count($filters);

        return $countProjects;
    }
}
?>