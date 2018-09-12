<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use App\Employees;
use JWTAuthException;
use \App\Response\Response;

class BillsController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function conciliation() {

        $this->response->setDataSet("bills", []);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }
}
