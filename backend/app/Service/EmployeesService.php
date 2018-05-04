<?php 
namespace App\Service;
use Illuminate\Http\Request;
use App\Employees;

class EmployeesService extends Service
{
    private $employees;

    public function __construct()
    {
        $this->employees = new Employees();
    }

    public function create(Request $request)
    {
        $returnUser = $this->employees->create([
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'adress' => $request->get('adress'),
            'adress_number' => $request->get('adress_number'),
            'adress_complement' => $request->get('adress_complement'),
            'adress_district' => $request->get('adress_district'),
            'zip_code' => $request->get('zip_code'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
        ]);

        return $returnUser;
    }

    public function findUserByEmail(Request $request)
    {
        $returnUser = $this->employees->findUserByEmail($request->get('email'));
        return $returnUser;
    }

    public function findUserByToken(Request $request)
    {
        $returnUser = $this->employees->findUserByToken($request->get('token'));
        return $returnUser;
    }
}
?>