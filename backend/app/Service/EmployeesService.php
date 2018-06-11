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
            'sunday_in' => $request->get('sunday_in'),
            'sunday_out' => $request->get('sunday_out'),
            'monday_in' => $request->get('monday_in'),
            'monday_out' => $request->get('monday_out'),
            'tuesday_in' => $request->get('tuesday_in'),
            'tuesday_out' => $request->get('tuesday_out'),
            'wednesday_in' => $request->get('wednesday_in'),
            'wednesday_out' => $request->get('wednesday_out'),
            'thursday_in' => $request->get('thursday_in'),
            'thursday_out' => $request->get('thursday_out'),
            'friday_in' => $request->get('friday_in'),
            'friday_out' => $request->get('friday_out'),
            'saturday_in' => $request->get('saturday_in'),
            'saturday_out' => $request->get('saturday_out'),
            'use_time_control' => $request->get('use_time_control'),
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