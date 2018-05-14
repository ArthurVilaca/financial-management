<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\TaxesService;
use \App\Taxes;

class TaxesController extends Controller
{
    private $response;
    private $taxes;
    private $taxesService;

    public function __construct()
    {
        $this->response = new Response();
        $this->taxesService = new TaxesService();
        $this->taxes = new Taxes();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $taxes = $this->taxes->get();

        $this->response->setDataSet("taxes", $taxes);
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
        $returnTax = $this->taxesService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("user", $returnTax);
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
        $tax = $this->taxes->find($id);

        $this->response->setDataSet("tax", $tax);
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
        $tax = $this->taxes->find($id);

        $tax_data = $request->all();
        $tax->fill($tax_data);
        $tax->save();

        $this->response->setDataSet("tax", $tax);
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

    /**
     * Store a newly created resource in fk of provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function provider(Request $request, $provider_id)
    {
        $returnTax = $this->taxesService->createProvider($request, $provider_id);
            
        $this->response->setType("S");
        $this->response->setDataSet("tax", $returnTax);
        $this->response->setMessages("Created tax successfully!");
        
        return response()->json($this->response->toString(), 200);
    }

    /**
     * Store a newly created resource in fk of client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function client(Request $request, $client_id)
    {
        $returnTax = $this->taxesService->createClient($request, $client_id);
            
        $this->response->setType("S");
        $this->response->setDataSet("tax", $returnTax);
        $this->response->setMessages("Created tax successfully!");
        
        return response()->json($this->response->toString(), 200);
    }
}
