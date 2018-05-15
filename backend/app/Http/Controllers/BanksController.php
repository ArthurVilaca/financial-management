<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\BanksService;
use \App\Banks;

class BanksController extends Controller
{
    private $response;
    private $banks;
    private $banksService;

    public function __construct()
    {
        $this->response = new Response();
        $this->banksService = new BanksService();
        $this->banks = new Banks();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $banks = $this->banks->get();

        $this->response->setDataSet("banks", $banks);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
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
        $returnBank = $this->banksService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("bank", $returnBank);
        $this->response->setMessages("Created bank successfully!");
        
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
        $bank = $this->banks->find($id);

        $this->response->setDataSet("bank", $bank);
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
        $bank = $this->banks->find($id);

        $bank_data = $request->all();
        $bank->fill($bank_data);
        $bank->save();

        $this->response->setDataSet("tax", $bank);
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
}
