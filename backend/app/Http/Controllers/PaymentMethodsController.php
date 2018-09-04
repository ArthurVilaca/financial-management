<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\PaymentMethodsService;
use \App\PaymentMethods;

class PaymentMethodsController extends Controller
{
    private $response;
    private $paymentMethods;
    private $paymentMethodsService;

    public function __construct()
    {
        $this->response = new Response();
        $this->paymentMethodsService = new PaymentMethodsService();
        $this->paymentMethods = new PaymentMethods();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = $this->paymentMethods->get();

        $this->response->setDataSet("paymentMethods", $paymentMethods);
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
        $returnLoan = $this->paymentMethodsService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("Loan", $returnLoan);
        $this->response->setMessages("Created Loan successfully!");
        
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
        $paymentMethods = $this->paymentMethods->find($id);

        $this->response->setDataSet("paymentMethods", $paymentMethods);
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
        $paymentMethods = $this->paymentMethods->find($id);

        $paymentMethods_data = $request->all();
        $paymentMethods->fill($paymentMethods_data);
        $paymentMethods->save();

        $this->response->setDataSet("paymentMethods", $paymentMethods);
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
