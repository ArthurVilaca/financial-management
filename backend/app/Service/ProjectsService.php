<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Projects;
use App\ProjectsPhases;

class ProjectsService extends Service
{
    private $projects;
    private $projectsPhases;

    public function __construct()
    {
        $this->projects = new Projects();
        $this->projectsPhases = new ProjectsPhases();
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
        }

        return $returnProject;
    }

    public function getProjectPhases($id) {
        $phases = $this->projectsPhases->findByProject($id);
        return $phases;
    }

}
?>