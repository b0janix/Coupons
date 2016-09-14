<?php

namespace App\Services;
//dd()
use App\Repositories\CouponRepositoryInterface;
use App\Repositories\WorkerRepositoryInterface;
use App\Validators\CouponDistributionValidator;

class DistributionService implements DistributionServiceInterface {

protected $worker_repository;
protected $coupon_repository;

function __construct(WorkerRepositoryInterface $worker_repository,CouponRepositoryInterface $coupon_repository)  {
$this->worker_repository=$worker_repository;
$this->coupon_repository=$coupon_repository;
}
//*
public function saveDistributionInputs($request){
/*In the distributionCreate view I'm creating the input fields dynamically using jQuery so secret is a 
hidden input filed where i store the number of those fields*/
$x=$request->input('secret');
//The title is created by concatinating the values of the fields bellow
$title=$request->input('month')." ".$request->input('date')." ".$request->input('meal');
//The fields accountNumber and workerName will return an array of values
$inputAccount=$request->input('accountNumber');
$inputName=$request->input('workerName');
//The number of items in those arrays is equal to x, a value which i've already got 
for($i=0;$i<$x;$i++){
// For the $i member of the array i'm calling a method from the worker repository that returns that worker's id
$idDB=$this->worker_repository->returnWorkersId($inputAccount[$i],$inputName[$i]);
//Also returns an array of values
$input_c=$request->input('couponNumber');
//Method that creates the given coupon and relates to an existing worker (many to many relationship)
$this->coupon_repository->relateCouponsToWorkers(['coupon_number'=>$input_c[$i]],$idDB,$request->input('year'),$request->input('month'),$request->input('date'), $request->input('meal'), $title);}
      
    }
//*
public function returnTitle() {
$coupons=$this->coupon_repository->returnCouponsWithWorkers();
if(count($coupons)==0){
return [];
}
foreach ($coupons as $coupon){

if(count($coupon->workers)==0){
return [];
}
//And this is how the pivot table coupon_worker and the pivot fields are accessed
foreach ($coupon->workers as $pivot){
$titles[]=$pivot->pivot->title;
}
}
if(!$titles){
return [];
}
$titles=array_unique($titles);
return $titles;
} 

public function returnWantedCoupons($title) {
//Returns all coupons related with workers
$coupons=$this->coupon_repository->returnCouponsWithWorkers();
foreach ($coupons as $coupon){
foreach ($coupon->workers as $pivot){
//For each coupon takes the value of the title field in the pivot table and compares with the value of the fetched title variable
if($pivot->pivot->title==$title){
//If it returns true we are putting those coupon ids in to an array
$ids[]=$pivot->pivot->coupon_id;
}
}
}
foreach($ids as $id){
//For each coupon id of that array i'm finding and returning the apropriate coupon object which i'm storing in a new array
$new[]=$this->coupon_repository->findCouponById($id);
}
return $new;
}
//*
public function returnWantedWorkers($title) {
//Returns all workers related with coupons
$workers=$this->worker_repository->returnWorkersWithCoupons();
foreach ($workers as $worker){
foreach ($worker->coupons as $pivot){
//For each worker takes the value of the title field in the pivot table and compares with the value of the fetched title variable
if($pivot->pivot->title==$title){
//If it returns true we are putting those worker ids in to an array
$ids[]=$pivot->pivot->worker_id;
}
}
}
foreach($ids as $id){
//For each worker id of that array i'm finding and returning the apropriate worker object which i'm storing in a new array
$new[]=$this->worker_repository->findWorkerById($id);
}
return $new;
}
//*
public function verifyBeforeDeleting($request){
/*secret is a hidden input field in which are stored the texts of all checked boxes from the checkbox in the dlist view,
so i'm using the json_decode method to turn the json encoded strings into a php array
*/
$array=json_decode($request->input('secret'));

foreach($array as $member){
/*each member is a string that contains the coupon number of the worker's coupon for that month, 
the worker's account number and the worker's name. I'm turning those into an array*/
$arrayTwo[]=explode(" ",$member);
}

foreach($arrayTwo as $memberTwo){
//returns all the coupons with the given number
$coupons[]=$this->coupon_repository->returnCouponsByNumber($memberTwo[0]);
}
foreach($coupons as $coupon){
foreach($coupon as $c){
foreach($c->workers as $pivot){
/*for all the values from the meal field, of the coupon_worker table, that are equal to the values from the hidden input meal field and for all the values from the month field, of the coupon_worker table, that are equal to the value from the hidden 
input month field return the coupon ids*/
if($pivot->pivot->meal==$request->input('meal') && $pivot->pivot->month==$request->input('month')){
$ids[]=$c->id;}
      }
    }
  }
//If the array is not empty
if(count($ids)>0){
return $ids;
  }
//if it's empty and the if statement returns false so the ids array wont be defined
return $empty=[];
}

public function returnTheSelectedCouponsAndWorkers($array){

foreach ($array as $member){
//for each id of the array finds the coupon object 
$coupons[]=$this->coupon_repository->findCouponById($member);
}

foreach ($coupons as $coupon){
foreach ($coupon->workers as $worker){
/* for each coupon object retrieve the coupon number of that object, and the account number 
and the worker name of the related worker object as an array and put them into another array*/
$checkedIn[]=[$coupon->coupon_number,$worker->accountNumber,$worker->workerName];
}  
}
/*from the array of coupon ids i'm creating a string because it is going to be sent as a parameter attached 
to the distribute.destroy route*/
$ids=implode(" ",$array);
return [$ids,$checkedIn];
}

public function destroy($string){
// the string is turned into an array of ids again
$ids=explode(" ",$string);
// and finally passed to the laravel delete function
$this->coupon_repository->delete($ids);
}

}




