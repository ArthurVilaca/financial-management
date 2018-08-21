<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\BillspayService;
use \App\Billspays;
use \App\Clients;

class BillspayController extends Controller
{
    private $response;
    private $billspays;
    private $billspayService;
    private $clients;

    public function __construct()
    {
        $this->response = new Response();
        $this->billspayService = new BillspayService();
        $this->billspays = new Billspays();
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

        $billspays = $this->billspayService->load($page, $pageSize, $_GET);
        $total = $this->billspayService->count($_GET);
        foreach ($billspays as $key => $value) {
            $value->client = $this->clients->find($value->clients_id);
        }

        $this->response->setDataSet("billspays", $billspays);
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
    public function store(Request $request) {
        $request->payment_date = new \DateTime($request->payment_date);
        $request->payment_date->format('Y-m-d H:i:s');
        $request->invoice_date = new \DateTime($request->invoice_date);
        $request->invoice_date->format('Y-m-d H:i:s');
        $returnBill = $this->billspayService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("billspay", $returnBill);
        $this->response->setMessages("Created billspay successfully!");
        
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
        $billspay = $this->billspays->find($id);

        $this->response->setDataSet("billspay", $billspay);
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
        if($request->changeValue && $request->changeValueText){
            if($request->changeValueText == 'discount'){
                if($request->amount > $request->changeValue){
                    $request->amount = $request->amount - $request->changeValue;
                }
            }if($request->changeValueText == 'addition'){
                $request->amount = $request->amount + $request->changeValue;
            }
        }
        $request->payment_date = new \DateTime($request->payment_date);
        $request->invoice_date = new \DateTime($request->invoice_date);
        $billspay = $this->billspays->find($id);
        $billspay_data = $request->all();
        $billspay->fill($billspay_data);
        $billspay->save();

        $this->response->setDataSet("billspay", $billspay);
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
