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
use \App\Service\ReportCashFlowService;

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
        $this->reportCashFlow = new ReportCashFlowService();
    }

    public function getCashFlow(Request $request){
        $cashFlow = $this->reportCashFlow->getCashFlow($_GET);

        $this->response->setDataSet("billsCostCenter", $cashFlow);
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
        $expenses = $this->billspays->getReport($_GET);

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

    public function getCashFlowMonth(Request $request){
        $cashFlow = $this->reportCashFlow->getCashFlowMonth($_GET);

        $this->response->setDataSet("billsCostCenter", $cashFlow);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());
    }

    public function getDreFlow(Request $request){

        $cashFlowDre = $this->reportCashFlow->getDreFlow($_GET);
        $this->response->setDataSet("reportDreCashFlow", $cashFlowDre);
        $this->response->setType("S");
        $this->response->setMessages("Sucess!");

        return response()->json($this->response->toString());

    }
}
