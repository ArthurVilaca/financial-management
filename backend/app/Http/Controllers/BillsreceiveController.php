<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\BillsreceiveService;
use \App\Billsreceives;
use \App\Clients;

class BillsreceiveController extends Controller
{
    private $response;
    private $billsreceives;
    private $billsreceiveService;
    private $clients;

    public function __construct()
    {
        $this->response = new Response();
        $this->billsreceiveService = new BillsreceiveService();
        $this->billsreceives = new Billsreceives();
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

        $billsreceive = $this->billsreceiveService->load($page, $pageSize, $_GET);
        $total = $this->billsreceiveService->count($_GET);
        foreach ($billsreceive as $key => $value) {
            $value->client = $this->clients->find($value->clients_id);
        }

        $this->response->setDataSet("billsreceive", $billsreceive);
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
        if($request->projectInvoice){
            $returnBill = $this->billsreceiveService->generateInvoice($request->projects_id);
        }else{
            $returnBill = $this->billsreceiveService->create($request);
        }        
            
        $this->response->setType("S");
        $this->response->setDataSet("billsreceive", $returnBill);
        $this->response->setMessages("Created billsreceive successfully!");
        
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
        $billsreceive = $this->billsreceives->find($id);

        $this->response->setDataSet("billsreceive", $billsreceive);
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
        $billsreceive = $this->billsreceives->find($id);

        $billsreceive_data = $request->all();
        $billsreceive->fill($billsreceive_data);
        $billsreceive->save();

        $this->response->setDataSet("billsreceive", $billsreceive);
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
