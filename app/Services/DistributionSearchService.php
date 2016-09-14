<?php

namespace App\Services;

use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\CouponRepositoryInterface;
use DB;

class DistributionSearchService implements DistributionSearchServiceInterface {

protected $department_repository;
protected $coupon_repository;

function __construct(DepartmentRepositoryInterface $department_repository, CouponRepositoryInterface $coupon_repository){

$this->department_repository=$department_repository;
$this->coupon_repository=$coupon_repository;
  }
//This  large query is intended for retrieving results using multiple criterions
//Or simply put, if you want to retrieve multiple information who are related to certain worker
// and you want all that information in one place, use multiple input fields that will serve as search bars
//For this purpose I'm using the fluent query builder and not eloquent
//It's more flexible and easier to update the query
public function fluentQuery($request){
$year=$request->input('year');
$month=$request->input('month');
$meal=$request->input('meal');
$cnumber=$request->input('couponNumber');
$anumber=$request->input('accountNumber');
$name=$request->input('workerName');
$department=$request->input('department');
$query=DB::table('workers')->join('coupon_worker','workers.id','=','coupon_worker.worker_id')
->join('departments','workers.department_id','=','departments.id');
if ($year!=null) {
$query = $query->where('coupon_worker.year','=',$year);
}
if ($month!=null) {
$query = $query->where('coupon_worker.month','=',$month);
}
if ($meal!=null) {
$query = $query->where('coupon_worker.meal','=',$meal);
}
if ($cnumber!=null) {
//first retrieve the coupon ids on the base of the coupon data input
$coupons=$this->coupon_repository->returnCouponsbyNumber($cnumber);
for($i=0;$i<count($coupons);$i++){
$cids[]=$coupons[$i]->id;
}

//then you can use those coupon ids as filters in this query
$query=$query->whereIn('coupon_worker.coupon_id',$cids);}

if ($anumber!=null) {
$query = $query->where('workers.accountNumber','=',$anumber);
}
if ($name!=null) {
$query = $query->where('workers.workerName','=',$name);
}
if ($department!=null) {
//same as coupons
$object=$this->department_repository->findDepartmentByName($department);
$id=$object->id;
$query = $query->where('workers.department_id','=',$id);
}
//after you finished with building the query and filtering the results
//select the returned values from the following fields
$results=$query->select('coupon_worker.year', 'coupon_worker.month', 'coupon_worker.meal', 'coupon_worker.coupon_id',
 'workers.accountNumber',  'workers.workerName', 'workers.department_id')->get();

if(count($results)==0){
return [[],[],[]];
}

for($i=0;$i<count($results);$i++){
//again find the ids for coupons and departments
$coupids[]=$results[$i]->coupon_id;
$depids[]=$results[$i]->department_id;
}
for($i=0;$i<count($results);$i++){
//then find their respective objects
$coupons[]=$this->coupon_repository->findCouponById($coupids[$i]);
$departments[]=$this->department_repository->findDepartment($depids[$i]);
}

for($i=0;$i<count($results);$i++){
//and even then the values of their properties that you need for presentation
$couponNumbers[]=$coupons[$i]->coupon_number;
$departmentNames[]=$departments[$i]->departmentName;
}
return [$results,$couponNumbers,$departmentNames];
}

}