<?php

namespace App\Services;

use App\Repositories\WorkerRepositoryInterface;
use App\Repositories\DepartmentRepositoryInterface;
use App\Validators\WorkerValidator;

class WorkerGenerator implements WorkerGeneratorInterface {

protected $worker_repository;
protected $department_repository;
protected $v;

function __construct(WorkerRepositoryInterface $worker_repository,DepartmentRepositoryInterface $department_repository, WorkerValidator $v)  {
$this->worker_repository=$worker_repository;
$this->department_repository=$department_repository;
$this->v=$v;
  }
//*
  public function showAllWorkers()  {
  return $this->worker_repository->workersAndDepartments();
  }

//*
  public function listAllDepartments()  {
  return $this->department_repository->showAllDepartments();
  }

//*
public function generateWorkers($request) {
$this->worker_repository->createWorkers(['accountNumber'=>$request->input('accountNumber'),
// $request->input('departmentName') will return the id of the selected department
'workerName'=>$request->input('workerName')], $this->department_repository->findDepartment($request->input('departmentName')));
}

//*
public function showSingleWorker($id) {
return $this->worker_repository->findSingleWorker($id);
  }
//*
public function theDepartmentsId($id)  {
return $this->worker_repository->workersDepartment($id);
  }

//*
public function updateWorker($id, $request) {
//passes the worker's to worker's repository method id and an array of the data entered which are required by laravel's update method
$this->worker_repository->changeWorker($id, ['accountNumber'=>$request->input('accountNumber'),
'workerName'=>$request->input('workerName')], $this->department_repository->findDepartment($request->input('departmentName')));
}    
//*
 public function destroyWorker($id)  {
  $this->worker_repository->deleteWorker($id);
   }

}