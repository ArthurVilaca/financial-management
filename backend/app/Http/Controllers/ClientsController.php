<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\ClientsService;
use \App\Clients;

class ClientsController extends Controller
{
    private $response;
    private $clients;
    private $clientsService;

    public function __construct()
    {
        $this->response = new Response();
        $this->clientsService = new ClientsService();
        $this->clients = new Clients();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Input::get('page');
        if( !isset($page)  ) {
            $page = 0;
        }
        $pageSize = Input::get('pageSize');
        if( !isset($pageSize)  ) {
            $pageSize = 10;
        }

        $clients = $this->clientsService->load($page, $pageSize);
        $total = $this->clientsService->count();

        $this->response->setDataSet("clients", $clients);
        $this->response->setDataSet("total", $total);
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
        $returnClient = $this->clientsService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("client", $returnClient);
        $this->response->setMessages("Created client successfully!");
        
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
        $client = $this->clients->find($id);
        $client->taxes = $this->clientsService->loadTaxes($id);

        $this->response->setDataSet("client", $client);
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
        $client = $this->clients->find($id);

        $client_data = $request->all();
        $client->fill($client_data);
        $client->save();

        $this->response->setDataSet("tax", $client);
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
