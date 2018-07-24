<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;

class ProvidersController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

}
