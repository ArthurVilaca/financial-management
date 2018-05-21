<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Projects;

class ProjectsService extends Service
{
    private $projects;

    public function __construct()
    {
        $this->projects = new Projects();
    }

    public function create(Request $request)
    {
        $returnTax = $this->projects->create([
            'name' => $request->get('name'),
            'notes' => $request->get('notes'),
            'status' => $request->get('status'),
            'amount' => $request->get('amount'),
            'clients_id' => $request->get('clients_id'),
        ]);

        return $returnTax;
    }

}
?>