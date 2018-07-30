<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Billspays;
use \App\Billsreceives;

class ReportsController extends Controller
{
    private $response;
    private $billspays;
    private $billsreceives;

    public function __construct()
    {
        $this->response = new Response();
        $this->billspays = new Billspays();
        $this->billsreceives = new Billsreceives();
    }

    public function billspay(Request $request) {
        $billspays = $this->billspays->getReport($_GET);

        $this->response->setDataSet("billspays", $billspays);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }

    public function billsreceive(Request $request) {
        $billsreceives = $this->billsreceives->getReport($_GET);

        $this->response->setDataSet("billsreceives", $billsreceives);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }
}
