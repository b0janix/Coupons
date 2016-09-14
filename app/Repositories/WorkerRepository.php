<?php
namespace App\Repositories;

use App\Worker;
use DB;

class WorkerRepository implements WorkerRepositoryInterface{

  protected $worker;
  function __construct(Worker $worker)  {
    $this->worker=$worker;
  }
//*
public function workersAndDepartments() {
//Returns the workers which are already attached to departments/Eager Loading
return $this->worker->with('department')->get();
  }

//*
public function createWorkers($input, $dbdep) {
//First creates the worker into the database
 $new=$this->worker->create($input);
 //Then it asociates with the selected department, the associate method will accept the object of the selected department
 $new->department()->associate($dbdep);
 $new->save();
  }

//*
public function findSingleWorker($id) {
return $this->worker->where('id','=',$id)->first();
  }

//*
public function workersDepartment($id)  {
//finds the worker by his id
$the_worker=$this->worker->where('id','=',$id)->first();
//returns the id of the worker's department by using the laravel helper function value, which returns the value that is given to it
return $the_worker->department()->value('id');
  }

//*
public function changeWorker($id, $input, $dbdep) {
//First finds the worker
$wu=$this->worker->where('id','=',$id)->first();
//Then updates the worker with the data which are passed
$wu->update($input);
//Attaches the updated worker to the department selected from the form
$wu->department()->associate($dbdep);
$wu->save();
  }

//*
public function deleteWorker($id) {
//Firstly finds the worker
$delete=$this->worker->findOrFail($id);
//Then deletes him
$delete->forceDelete();
  }
//*
public function returnWorkersId($inputAccount, $inputName) {
return $this->worker->where('accountNumber','=',$inputAccount)
->where('workerName','=',$inputName)->first()->id;
  }

//*
public function returnWorkersWithCoupons(){
//Eager loads all workers that have a relationship with coupons into the user_worker table
return $this->worker->with('coupons')->get();
}
//*
public function findWorkerById($id){
return $this->worker->where('id','=',$id)->first();
}

//*
public function findWorkerByNumber($term)  {
return $this->worker->with('department')->where('accountNumber','like','%'.$term.'%')->firstOrFail();
  } 

//*
public function  findWorkerByNumberFiltered($number, $month, $meal){
/*return the worker object that has month and meal values in the pivot coupon_worker table and that those values are equal 
to the ones that we are fetching as arguments in this method. Identical is the case of the account number field. The point 
is to check whether that worker with that account number for the specified month and meal is already stored in the database  */
return $this->worker->with('coupons')->join('coupon_worker','workers.id','=','coupon_worker.worker_id')->where('coupon_worker.month','=', $month)->where('coupon_worker.meal','=', $meal)->where('workers.accountNumber','=', $number)->first();
}

//*
public function findWorkerByName($term)  {
return $this->worker->where('workerName','like','%'.$term.'%')->first();
  }

//*
public function returnWorker($inputAccount, $inputName) {
return $this->worker->where('accountNumber','=',$inputAccount)
->where('workerName','=',$inputName)->first();
  }

public function findCouponId($id,$month, $meal){
return $this->worker->join('coupon_worker','workers.id','=','coupon_worker.worker_id')
->where('coupon_worker.worker_id','=',$id)->where('coupon_worker.month','=',$month)->where('coupon_worker.meal','=',$meal)
->first()->coupon_id;
}


/*
public function findWorkerWithCoupon()  {
return $this->worker->with('coupons')->latest()->get()->toArray();
}

public function returnWorkersWithProcessingTitle(){
return $this->worker->with('construction_sites')->get();
}

public function returnWorkersWithProcessingTitleByNameAndAccount($input1,$input2){
return $this->worker->with('construction_sites')->where('workerName','=',$input2)->where('accountNumber','=',$input1)->first();
}

public function returnClickedTitleW($title){
return $this->worker->join('construction_site_worker','workers.id','=','construction_site_worker.worker_id')
->where('title','=',$title)->select('construction_site_worker.title')->first();
}

public function queryWorkerByNumberNameAndTitle($title, $acc_num, $work_name){
return $this->worker->join('construction_site_worker','workers.id','=','construction_site_worker.worker_id')
->where('construction_site_worker.title','=',$title)->where('workers.accountNumber','=',$acc_num)
->where('workers.workerName','=',$work_name)->select('workers.id')->first();
}

public function queryWorkerByNumberNameAndId($acc_num,$work_name,$wid){
return $this->worker->where('id','=',$wid)->where("accountNumber","=",$acc_num)->where("workerName","=",$work_name)->get();
}

public function findTitleByIds($id,$title){
return $this->worker->join('construction_site_worker','workers.id','=','construction_site_worker.worker_id')
->where('construction_site_worker.worker_id','=',$id)->where('construction_site_worker.title','=',$title)
->select('construction_site_worker.title')->get()->toArray();}

public function findIdsByTitle($title){
return $this->worker->join('construction_site_worker','workers.id','=','construction_site_worker.worker_id')
->where('construction_site_worker.title','=',$title)
->select('construction_site_worker.worker_id')->get()->toArray();}*/

}