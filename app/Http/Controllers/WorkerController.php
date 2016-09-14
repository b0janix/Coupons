<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\WorkerGeneratorInterface;
use App\Services\AccessControlInterface;
use App\Validators\WorkerValidator;

class WorkerController extends Controller
{

  protected $wg;
  protected $ac;

function __construct(WorkerGeneratorInterface $wg, AccessControlInterface $ac)  {
$this->wg=$wg;
$this->ac=$ac;
//Checks whether visitor is authenticated
$this->middleware('authenticate');
  }

    //
public function index() {
//Calls a method that checks whether user has editor permission
$this->ac->checkForPermission();
//Calls a method from WorkerGenerator's Service that returns all workers (I haven't used pagination)
$workers=$this->wg->showAllWorkers();
//I'm passing them to the index view using the PHP function compact()
return view('worker.index', compact('workers'));
  }

public function create(Request $request) {
//Calls a method that checks whether user has editor permission
$this->ac->checkForPermission();
//Returns all departments
$departments=$this->wg->listAllDepartments();
return view('Worker.create', compact('departments'));
  }

public function store(Request $request, WorkerValidator $v) {
//I'm calling a method from the validation class that returns the validator object if validation fails
$validator=$v->validateWorkerCreation($request);
if ($validator) {
return redirect()->route('worker.create')
->withErrors($validator)
->withInput();
  }
//If validation passes it will execute the method that stores the data in to the database
$this->wg->generateWorkers($request);
return redirect()->route('worker.index');
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function show($id)
    {
//Calls a method that checks whether user has editor permission
$this->ac->checkForPermission();
//Calls a method that finds the worker with the given id
$single=$this->wg->showSingleWorker($id);
//passes the single variable to the worker view
return view('worker.worker', compact('single'));
  }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function edit($id)
{
//Calls a method that checks whether user has editor permission
$this->ac->checkForPermission();
//Calls a method that finds the worker with the given id
$single=$this->wg->showSingleWorker($id);
//Returns all departments
$departments=$this->wg->listAllDepartments();  
//returns the worker's department id
$wordep=$this->wg->theDepartmentsId($id);
return view('Worker.edit', compact('single','departments','wordep'));
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(WorkerValidator $v, Request $request, $id)
{

$validator=$v->validateWorkerCreation($request);
if ($validator) {
return redirect()->route('worker.edit',['id'=>$id])
->withErrors($validator)
->withInput();
  }

$this->wg->updateWorker($id, $request);
return redirect()->route('worker.index');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
public function destroy($id) {
$this->wg->destroyWorker($id);
return redirect()->route('worker.index');
    }
}
