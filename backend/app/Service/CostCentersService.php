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

    public function load($page, $pageSize, $filters)
    {
        if(isset($filters) && $filters!= ''){
            $returnCostCenter = $this->costCenters->loadCostCentersFilters($page, $pageSize, $filters);            
        }else{
            $returnCostCenter = $this->costCenters->loadCostCenters($page, $pageSize);
        }

        return $returnCostCenter;
    }

    public function count()
    {
        $countCostCenters = $this->costCenters->count();

        return $countCostCenters;
    }

}
?>