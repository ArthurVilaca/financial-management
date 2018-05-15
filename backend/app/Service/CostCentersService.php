<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\CostCenters;

class CostCentersService extends Service
{
    private $costCenters;

    public function __construct()
    {
        $this->costCenters = new CostCenters();
    }

    public function create(Request $request)
    {
        $returnBank = $this->costCenters->create([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
        ]);
        return $returnBank;
    }

}
?>