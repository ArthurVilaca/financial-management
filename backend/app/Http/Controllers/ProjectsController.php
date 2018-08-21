<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use JWTAuthException;
use \App\Response\Response;
use \App\Service\ProjectsService;
use \App\Projects;

class ProjectsController extends Controller
{
    private $response;
    private $projects;
    private $projectsService;

    public function __construct()
    {
        $this->response = new Response();
        $this->projectsService = new ProjectsService();
        $this->projects = new Projects();
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

        $projects = $this->projectsService->load($page, $pageSize, $_GET);
        $total = $this->projectsService->count($_GET);

        $this->response->setDataSet("projects", $projects);
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
        $returnProject = $this->projectsService->create($request);
            
        $this->response->setType("S");
        $this->response->setDataSet("projects", $returnProject);
        $this->response->setMessages("Created projects successfully!");
        
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
        $projects = $this->projects->find($id);
        $projects->projects_phases = $this->projectsService->getProjectPhases($id);
        foreach ($projects->projects_phases as $key => $value) {
            $value->billspay = $this->projectsService->getProjectBillspay($value->id);
            $value->billsreceive = $this->projectsService->getProjectBillsreceive($value->id);
        }

        $this->response->setDataSet("projects", $projects);
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
        $projects = $this->projects->find($id);

        $projects_data = $request->all();
        $projects->fill($projects_data);
        $projects->save();

        $this->response->setDataSet("projects", $projects);
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
