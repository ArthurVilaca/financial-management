<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use App\Employees;
use JWTAuthException;
use \App\Response\Response;

class DashboardController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new Response();
    }

}
