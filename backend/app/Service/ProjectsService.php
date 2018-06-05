<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Projects;
use App\ProjectsPhases;
use App\Billspay;
use App\Billsreceive;

class ProjectsService extends Service
{
    private $projects;
    private $projectsPhases;
    private $billspay;
    private $billsreceive;

    public function __construct()
    {
        $this->projects = new Projects();
        $this->projectsPhases = new ProjectsPhases();
        $this->billspay = new Billspay();
        $this->billsreceive = new Billsreceive();
    }

    public function create(Request $request)
    {
        $returnProject = $this->projects->create([
            'name' => $request->get('name'),
            'notes' => $request->get('notes'),
            'status' => $request->get('status'),
            'amount' => $request->get('amount'),
            'clients_id' => $request->get('clients_id'),
        ]);

        $returnProject['projects_phases'] = [];
        $projects_phases = $request->get('projects_phases');
        foreach ($projects_phases as $key => $value) {

            $date = new \DateTime($value['expiration_date']);
            $returnPhase = $this->projectsPhases->create([
                'status' => $value['status'],
                'comments' => $value['comments'],
                'amount' => $value['amount'],
                'number' => $value['number'],
                'expiration_date' => $date,
                'projects_id' => $returnProject->id,
                'providers_id' => $value['provider_id']
            ]);

            for ($i=0; $i < $value['number']; $i++) { 
                $this->billspay->create([
                    'name' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                    'status' => 'Prevista',
                    'comments' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                    'amount' => $value['amount'],
                    'projects_phases_id' => $returnPhase->id,
                    'due_date' => $date,
                ]);
            }

            for ($i=0; $i < $value['number']; $i++) { 
                $this->billsreceive->create([
                    'name' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                    'status' => 'Prevista',
                    'comments' => 'Conta referente ao projeto '.$request->get('name').' - REF '.$date->format('Y-m'),
                    'amount' => $value['amount'],
                    'projects_id' => $returnProject->id,
                    'due_date' => $date,
                ]);
            }
        }

        return $returnProject;
    }

    public function getProjectPhases($id) {
        $phases = $this->projectsPhases->findByProject($id);
        return $phases;
    }

    public function getProjectBillspay($id) {
        $billspays = $this->billspay->findByProject($id);
        return $billspays;
    }

    public function getProjectBillsreceive($id) {
        $billsreceives = $this->billsreceive->findByProject($id);
        return $billsreceives;
    }
}
?>