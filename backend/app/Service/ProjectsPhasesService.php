<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\ProjectsPhases;

class ProjectsPhasesService extends Service
{
    private $projectsPhases;

    public function __construct()
    {
        $this->projectsPhases = new ProjectsPhases();
    }

    public function create(Request $request)
    {
        $returnPhase = $this->projectsPhases->create([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'expiration_date' => $request->get('expiration_date'),
            'projects_id' => $request->get('projects_id'),
        ]);

        return $returnPhase;
    }
}
?>