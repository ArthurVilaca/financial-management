<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Billspays;

class AlertsController extends Controller
{
    private $response;
    private $billspays;

    public function __construct()
    {
        $this->response = new Response();
        $this->billspays = new Billspays();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = $this->billspays->loadAlerts();

        $this->response->setDataSet("alerts", $alerts);
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
        $this->response->setType("S");
        $this->response->setDataSet("alerts", []);
        $this->response->setMessages("Created successfully!");
        
        return response()->json($this->response->toString(), 200);
    }
}
