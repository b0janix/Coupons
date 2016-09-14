<?php

namespace App\Services;

use App\Repositories\WorkerRepositoryInterface;
use App\Repositories\CouponRepositoryInterface;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\MonthRepositoryInterface;
use App\Repositories\MealRepositoryInterface;

class AutocompleteService implements AutocompleteServiceInterface {

protected $worker_repo;
protected $coupon_repo;
protected $department_repo;
protected $newMeal_repo;
protected $calendar_repo;
protected $title_repo;
protected $month;
protected $meal;

function __construct(WorkerRepositoryInterface $worker_repo, CouponRepositoryInterface $coupon_repo, DepartmentRepositoryInterface
$department_repo, MonthRepositoryInterface $month, MealRepositoryInterface $meal) {

$this->worker_repo=$worker_repo;
$this->coupon_repo=$coupon_repo;
$this->department_repo=$department_repo;
$this->month=$month;
$this->meal=$meal;
  }

public function searchWorker($term)  {
//Returnes a worker if the account number matches the term passed
$query=$this->worker_repo->findWorkerByNumber($term);
$department=$query->department;
// if we can access object properties return a multidimensional array 
if($query->workerName && $department->departmentName){
$array=[['label'=>$query->workerName,'value'=>$query->accountNumber,'department'=>$department->departmentName]];  
//the array that is inside will be transformed into a jsnon object and returned back to the autocomplete method  
return response()->json($array);
  }
  }

public function storeMonthMeal($request){
//we have two tables month an meal in the database
//try and get all the results from both tables
$resultOne=$this->month->returnResult();
$resultTwo=$this->meal->returnResult();
if (count($resultOne)==0 && count($resultTwo)==0){
//if there are no results insert the curent inputs from month and meal fields into the database
$this->month->insertTheInput($request->input('month'));
$this->meal->insertTheInput($request->input('meal'));
  }
//else update the existing rows with the inputs
$this->month->updateTheFirstRecord($request->input('month'));
$this->meal->updateTheFirstRecord($request->input('meal'));

}

public function returnCouponWithWorker($term){
//returns the single result form the month table
$firstMonth=$this->month->returnFirstResult();
//returns the single result form the meal table
$firstMeal=$this->meal->returnFirstResult();
/*returns the coupon oject on the base of the provided coupon number in the form, that by ajax request 
was sent to the route /coupon__search, and the month and the meal from above*/
$result=$this->coupon_repo->findCouponByNumberAutocomplete($term, $firstMonth->month, $firstMeal->meal);
//then through the workers relationship accesses the worker oject that is his pair
foreach($result->workers as $worker) {
  }
//in the worjer's object locates the department_id foreign key, which serves to find the apropriate department object
$did=$worker->department_id;
$department=$this->department_repo->findDepartmentById($did);
//at the end creates an asociative array of name=>value pairs that will be transformed into an array that holds json object
//that json object and its properties will determine the values set in the input fields by the autocomplete widget
$array=[$result->coupon_number, $worker->accountNumber, $worker->workerName, $department->departmentName];
$array=[['label'=>$array[2], 'value'=>$array[0], 'account'=>$array[1], 'department'=>$array[3]]];
return response()->json($array);
}

public function editCouponWithWorker($term){
//returns the single result form the month table
$firstMonth=$this->month->returnFirstResult();
//returns the single result form the meal table
$firstMeal=$this->meal->returnFirstResult();
/*returns the coupon oject on the base of the provided coupon number in the form, that by ajax request 
was sent to the route /coupon__search, and the month and the meal from above*/
$result=$this->coupon_repo->findCouponByNumberAutocomplete($term, $firstMonth->month, $firstMeal->meal);
//then through the workers relationship accesses the worker oject that is his pair
foreach($result->workers as $worker) {
  }
//at the end creates an asociative array of name=>value pairs that will be transformed into an array that holds json object
//that json object and its properties will determine the values set in the input fields by the autocomplete widget
$array=[$result->coupon_number, $worker->accountNumber, $worker->workerName];
$array=[['label'=>$array[2], 'value'=>$array[0], 'account'=>$array[1]]];
return response()->json($array);
}

public function returnIfDistributionDuplicate($request){
//returns the value of the month input field
$firstMonth=$this->month->returnFirstResult();
//returns the value of the meal input field
$firstMeal=$this->meal->returnFirstResult();
/*Basically what these two methods are doing is to check whether the entered values in the coupon and worker 
related input fields from the distributionCreate view already exist in the database */
$resultOne=$this->coupon_repo->findCouponByNumberFiltered($request->input('couponNumber'), $firstMonth->month, $firstMeal->meal);
$resultTwo=$this->worker_repo->findWorkerByNumberFiltered($request->input('accountNumber'), $firstMonth->month, $firstMeal->meal);
//If at least one of the results is not null the method will return the following notification
if($resultOne->coupon_number || $resultTwo->accountNumber){
return "Coupon/Account number already entered";
}
}

public function returnIfProcessingDuplicate($request){
//returns a worker object by providing the account number and the worker name as inputs
$worker=$this->worker_repo->returnWorker($request->input('accountNumber'), $request->input('workerName'));
//then returns the coupon id if the filters provided are the worker id, the meal and the date input
$result=$this->coupon_repo->returnCouponsId($worker->id, $request->input('meal'));

if($result!=null){
//if the result is not null returns the text bellow 
return "Coupon number already entered";
}
return false;
}

public function returnNameOfWorker($term){
$worker=$this->worker_repo->findWorkerByName($term);
$workers=[['label'=>$worker->workerName,'value'=>$worker->workerName]];
return response()->json($workers);
}

}