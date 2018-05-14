<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Response\Response;

class FunctionsController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }
 
    
    public function zipcode(Request $request, $number){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://viacep.com.br/ws/'. $number .'/json/');
        echo $res->getBody();
    }
}
