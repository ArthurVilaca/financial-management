<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Billspays;
use \App\Billsreceives;
use \App\CostCenters;

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
        $this->costCenter = new CostCenters();
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

        $filters = [];
        if( Input::get('date_month') !== null ) {
            $filters['date_month'] = Input::get('date_month');
        }
        var_dump($filters);die;

        $billspaysExpens = $this->billspays->getExpenses($page, $pageSize);
        $total = $this->costCenter->count();

        $this->response->setDataSet("billPayReceive", $billspaysExpens);
        $this->response->setDataSet("total", $total);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
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

    public function getExpenses(Request $request){
        $expenses = $this->billspays->getExpenses($_GET);

        $this->response->setDataSet("billspaysExpenses", $expenses);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");
        return response()->json($this->response->toString());
    }

    public function getRecipes(Request $request){
        $recipes = $this->billsreceives->getRecipes($_GET);

        $this->response->setDataSet("billsreceivesrecipes", $recipes);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");
        return response()->json($this->response->toString());
    }


}
