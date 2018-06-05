<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Employees;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\EmployeesService;

class EmployeesController extends Controller
{
    private $employees;
    private $employeesService;
    private $response;

    public function __construct()
    {
        $this->employees = new Employees();
        $this->response = new Response();
        $this->employeesService = new EmployeesService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employees->get();

        $this->response->setDataSet("employees", $employees);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }

    /**
     * Login employees
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $token = null;
        try 
        {
           if (!$token = JWTAuth::attempt($credentials)) 
           {
               $this->response->setType("N");
               $this->response->setMessages("invalid_username_or_password");
               return response()->json($this->response->toString(), 422);
           }
        } 
        catch (JWTAuthException $e) 
        {
            $this->response->setType("N");
            $this->response->setMessages("failed_to_create_token");
            return response()->json($this->response->toString(), 500);
        }
        
        $user = JWTAuth::toUser($token);

        if($user->status != "APROVADO")
        {
            $this->response->setType("N");    
            $this->response->setMessages("You don't have permission to do login!");
            return response()->json($this->response->toString(), 500);
        }

        $this->response->setType("S");
        $this->response->setDataSet("token", $token);
        $this->response->setMessages("Login successfully!");
        
        $this->response->setDataSet("name", $user->name);

        return response()->json($this->response->toString(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $returnEmployeer = $this->employeesService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("employeer", $returnEmployeer);
        $this->response->setMessages("Created user successfully!");
        
        return response()->json($this->response->toString(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->employees->find($id);

        $this->response->setDataSet("employee", $employee);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employeer = $this->employees->find($id);

        $employeer_data = $request->all();
        $employeer_data['password'] = bcrypt($employeer_data['password']);
        $employeer->fill($employeer_data);
        $employeer->save();

        $this->response->setDataSet("employeer", $employeer);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if(!$user) 
        {
            $this->response->setType("N");
            $this->response->setMessages("Record not found!");

            return response()->json($this->response->toString(), 404);
        }

        $user->delete();
    }

    public function profile(Request $request)
    {
        if($request->get('password') === $request->get('password2')) {
            $userLogged = $this->employeesService->getAuthUser($request);
            $userLogged->password = bcrypt($request->get('password'));
            $userLogged->save();

            $this->response->setType("S");
            $this->response->setDataSet("user", $userLogged);
            $this->response->setMessages("Password alterada com sucesso!");
        } else {
            $this->response->setType("N");    
            $this->response->setMessages("You don't have permission to do login!");
        }
        return response()->json($this->response->toString());
    }
}
