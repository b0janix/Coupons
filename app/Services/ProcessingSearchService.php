<?php

namespace App\Services;

use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\CouponRepositoryInterface;
use App\Repositories\ConstructionSiteRepositoryInterface;
use App\Repositories\NewMealRepositoryInterface;
use DB;

class ProcessingSearchService implements ProcessingSearchServiceInterface {

protected $department_repository;
protected $coupon_repository;
protected $site_repository;
protected $new_meal_repo;

function __construct(DepartmentRepositoryInterface $department_repository, CouponRepositoryInterface $coupon_repository, 
  ConstructionSiteRepositoryInterface $site_repository,NewMealRepositoryInterface $new_meal_repo){

$this->department_repository=$department_repository;
$this->coupon_repository=$coupon_repository;
$this->site_repository=$site_repository;
$this->new_meal_repo=$new_meal_repo;
  }
//This  large query is intended for retrieving results using multiple criterions
//Or simply put, if you want to retrieve multiple information who are related to certain worker
// and you want all that information in one place, use multiple input fields that will serve as search bars
//For this purpose I'm using the fluent query builder and not eloquent
//It's more flexible and easier to update the query
public function fluentQuery($request){
$month=$request->input('month');
$date=$request->input('date');
$from=$request->input('from');
$to=$request->input('to');
$site=$request->input('site');
$meal=$request->input('meal');
$cnumber=$request->input('couponNumber');
$anumber=$request->input('accountNumber');
$name=$request->input('workerName');
$department=$request->input('department');
$query=DB::table('workers')->join('processing_titles','workers.id','=','processing_titles.worker_id')
->join('calendars','workers.id','=','calendars.worker_id')
->join('new_meals','workers.id','=','new_meals.worker_id')
->join('departments','workers.department_id','=','departments.id');
if ($month!=null) {
$query = $query->where('calendars.month','=',$month);
}
if ($date!=null) {
$query = $query->where('calendars.date','=',$date);
}
if ($from!=null && $to!=null) {
//If you want to return results for certain time range between two dates
$query = $query->where('calendars.date','>=',$from)->where('calendars.date','<=',$to);
}
if ($meal!=null) {
$query = $query->where('new_meals.meal','=',$meal);
}
if ($site!=null) {
//find the site object
$site=$this->site_repository->findSiteByName($site);
//then its id
$sid=$site->id;
//and then use it as a filter in the query
$query = $query->where('new_meals.construction_site_id','=',$sid);
}
if ($cnumber!=null) {
//the same
$coupons=$this->coupon_repository->returnCouponsbyNumber($cnumber);
foreach($coupons as $coupon){
$ids[]=$coupon->id;
}
$query=$query->whereIn('new_meals.coupon_id',$ids);
}
if ($anumber!=null) {
$query = $query->where('workers.accountNumber','=',$anumber);
}
if ($name!=null) {
$query = $query->where('workers.workerName','=',$name);
}
if ($department!=null) {
//same
$object=$this->department_repository->findDepartmentByName($department);
$id=$object->id;
$query = $query->where('workers.department_id','=',$id);
}

//after you finished with building the query and filtering the results
//select the returned values from the following fields
$results=$query->select('calendars.month', 'calendars.date', 'new_meals.meal','new_meals.construction_site_id',
'new_meals.coupon_id', 'workers.accountNumber',  'workers.workerName', 'workers.department_id')->get();

if($results){
foreach($results as $result){
//create a large string from every result
$strings[]=$result->month." ".$result->date." ".$result->meal." ".$result->construction_site_id." ".$result->coupon_id." ".
$result->accountNumber." ".$result->workerName." ".$result->department_id;
}
//remove the duplicate members of the array
$strings=array_unique($strings);
foreach($strings as $string){
//then out of evevry string create separate array a put it in another empty array
$results1[]=explode(" ",$string);}

for($i=0;$i<count($results1);$i++){
//find the ids
$siteids[]=$results1[$i][3];
$coupids[]=$results1[$i][4];
$depids[]=$results1[$i][7];
}
for($i=0;$i<count($results1);$i++){
//find the objects
$sites[]=$this->site_repository->findSiteById($siteids[$i]);
$coupons[]=$this->coupon_repository->findCouponById($coupids[$i]);
$departments[]=$this->department_repository->findDepartment($depids[$i]);
}

for($i=0;$i<count($results1);$i++){
//fill these empty arrays with required values of the retrieved objects
$siteNames[]=$sites[$i]->name;
$couponNumbers[]=$coupons[$i]->coupon_number;
$departmentNames[]=$departments[$i]->departmentName;
}
return [$results1,$couponNumbers,$departmentNames,$siteNames];}

return false;
}


//returnes ana associative array of key=>value pairs in which the values of the keyes are equal to the array values
//the values are the names of construction sites
public function returnNeededSites(){
$sites=$this->site_repository->findAllSites();
foreach($sites as $site){
$siteNames[]=$site->name;
}
$siteNames=array_combine(array_values($siteNames),array_values($siteNames));
return $siteNames;
}
}



