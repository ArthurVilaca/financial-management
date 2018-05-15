<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Banks;

class BanksService extends Service
{
    private $banks;

    public function __construct()
    {
        $this->banks = new Banks();
    }

    public function create(Request $request)
    {
        $returnBank = $this->banks->create([
            'name' => $request->get('name'),
        ]);
        return $returnBank;
    }

}
?>