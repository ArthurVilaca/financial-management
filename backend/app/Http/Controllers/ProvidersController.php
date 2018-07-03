<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\ProvidersService;
use \App\Providers;

class ProvidersController extends Controller
{
    private $response;
    private $providers;
    private $providersService;

    public function __construct()
    {
        $this->response = new Response();
        $this->providersService = new ProvidersService();
        $this->providers = new Providers();
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

        $providers = $this->providersService->load($page, $pageSize);
        $total = $this->providersService->count();

        $this->response->setDataSet("providers", $providers);
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
        $returnProvider = $this->providersService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("Provider", $returnProvider);
        $this->response->setMessages("Created Provider successfully!");
        
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
        $provider = $this->providers->find($id);
        $provider->taxes = $this->providersService->loadTaxes($id);

        $this->response->setDataSet("provider", $provider);
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
        $provider = $this->providers->find($id);

        $provider_data = $request->all();
        $provider->fill($provider_data);
        $provider->save();

        $this->response->setDataSet("provider", $provider);
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
