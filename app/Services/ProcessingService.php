<?php

namespace App\Services;

use App\Repositories\ConstructionSiteRepositoryInterface;
use App\Repositories\CouponRepositoryInterface;
use App\Repositories\WorkerRepositoryInterface;
use App\Validators\CouponDistributionValidator;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\ProcessingTitleRepositoryInterface;
use App\Repositories\NewMealRepositoryInterface;
use App\Repositories\CalendarRepositoryInterface;
use App\NewMeal;
use App\Calendar;
use App\ProcessingTitle;



class ProcessingService implements ProcessingServiceInterface {

protected $site_repository;
protected $worker_repository;
protected $coupon_repository;
protected $v;
protected $department_repository;
protected $title_repository;
protected $new_meal_repository;
protected $calendar_repository;


function __construct(ConstructionSiteRepositoryInterface $site_repository, WorkerRepositoryInterface $worker_repository,
CouponRepositoryInterface $coupon_repository,CouponDistributionValidator $v,DepartmentRepositoryInterface $department_repository,
ProcessingTitleRepositoryInterface $title_repository, NewMealRepositoryInterface $new_meal_repository, 
CalendarRepositoryInterface $calendar_repository)  {
$this->site_repository=$site_repository;
$this->worker_repository=$worker_repository;
$this->coupon_repository=$coupon_repository;
$this->v=$v;
$this->department_repository=$department_repository;
$this->title_repository=$title_repository;
$this->new_meal_repository=$new_meal_repository;
$this->calendar_repository=$calendar_repository;
}

public function getTheSites(){ 
return $this->site_repository->findAllSites();
}
//*
public function attachDataToConstructionSite($request){
//x's value represents the number of worker and coupon related input fields in the Processing.create view
$x=$request->input('secret');
for($i=0;$i<$x;$i++){
$date=$request->input('date');
$month=$request->input('month');
$site=$request->input('siteName');
$meal=$request->input('meal');
$title=implode(" ",[$date, $site, $meal]);
//the bellow three are arrays
$inputAccount=$request->input('accountNumber');
$inputName=$request->input('workerName');
$input_c=$request->input('couponNumber');
$coupons=$this->coupon_repository->returnCouponsByNumber($input_c[$i]);
$idWorker=$this->worker_repository->returnWorkersId($inputAccount[$i],$inputName[$i]);
foreach($coupons as $coupon){
foreach($coupon->workers as $worker){
/*For everey copupon from the coupons array, if the worker id, accessed through the workers() 
relationship, is equal to the id returned on the base of the data entered in the create form 
and some of the meal and the month values in the coupon_worker table are equal to the ones 
we've retrieved from the form you can take the coupon_id from the same row and place it in the variable id*/ 
if($worker->id==$idWorker && $worker->pivot->meal==$meal && $worker->pivot->month==$month){
$id=$worker->pivot->coupon_id;
              }
            }
          }
$site=$this->site_repository->findSiteByName($site);
$worker=$this->worker_repository->findWorkerById($idWorker);
//On the base of that retrieved coupon_id from above we are returning the coupon object that suits our quest  
$couponNew=$this->coupon_repository->findCouponById($id);
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newMeal= new NewMeal;
$newMeal->meal=$meal;
//here we are actually attaching the new meal to the retrieved construction site, coupon and worker objects
$site->new_meals()->save($newMeal);
$couponNew->new_meals()->save($newMeal);
$worker->new_meals()->save($newMeal);
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newCalendar= new Calendar;
$newCalendar->date=$date;
$newCalendar->month=$month;
//here we are actually attaching the newCalendar object to the retrieved construction site, coupon and worker objects
$site->calendars()->save($newCalendar);
$couponNew->calendars()->save($newCalendar);
$worker->calendars()->save($newCalendar);
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newTitle= new ProcessingTitle;
$newTitle->title=$title;
//here we are actually attaching the newTitle object to the retrieved construction site, coupon and worker objects
$site->processing_titles()->save($newTitle);
$couponNew->processing_titles()->save($newTitle);
$worker->processing_titles()->save($newTitle);
   }
  }
//*
public function returnTitles(){
$titles=$this->title_repository->returnTitles();
if(count($titles)==0){
return $array=[];
} 
if(count($titles)>0){
foreach($titles as $title){
$array[]=$title->title; 
}
$array=array_unique($array);
return $array;  
}
}

//*
public function attachNonLunchDataToConstructionSite($request){
//we are returning all calendar objects for the specified date and month
//the objective is for every object to retrieve the worker_id foreign key and to put it in to an array $workIds
$objects=$this->calendar_repository->returnCalendarObjects($request->input('date'),$request->input('month'));
if(count($objects)==1){
$workIds[]=$objects->worker_id;
}
if(count($objects)>1){
foreach($objects as $object){
$workIds[]=$object->worker_id;
}
}
//now we have the ids of the workers who ate a meal on the date provided above

$inputAccount=$request->input('accountNumber');
$inputName=$request->input('workerName');
for($i=0;$i<count($inputAccount);$i++){
// the worker's id with the given account number and the name of the worker and place it into an array
//we are obtaining the worker's id based on the credentials provided into the create form
$wids[]=$this->worker_repository->returnWorkersId($inputAccount[$i],$inputName[$i]);}
/*if the array $wids and the $workIds array have members that are not identical, 
we might have a problem for those ids, because we can't determine the construction site 
at which the worker has spent his work day. That means that the worker
hasen't had a lunch at some of the company's construction sites in Skopje or that 
he hasn't had a lunch at all, but did have a breakfest or a supper in the hotel.*/
if(count(array_diff($wids,$workIds))>0){
$widsnl=array_values(array_diff($wids,$workIds));
foreach($widsnl as $widnl){
//For each of those worker ids we are searching the paired coupon ids from the pivot table, for the given meal
$cidsnl[]=$this->worker_repository->findCouponId($widnl, $request->input('month'), $request->input('meal'));}
for($i=0;$i<count($widsnl); $i++){
$date=$request->input('date');
$month=$request->input('month');
$meal=$request->input('meal');
/*For theese worker and coupon ids the title will have No lunch in the place where usually stands the name of the construction site. While the site object in this case will have a name No lunch.*/
$titleNoSite=$date." No lunch ".$meal;
$siteNL=$this->site_repository->findSiteByName('No lunch');
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newMeal= new NewMeal;
$newMeal->meal=$meal;
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newCalendar= new Calendar;
$newCalendar->date=$date;
$newCalendar->month=$month;
//I'm not using dependency injection because i'm getting the same object again and again, which ends up overwritten with each new cycle
$newTitle= new ProcessingTitle;
$newTitle->title=$titleNoSite;
$wkr=$this->worker_repository->findWorkerById($widsnl[$i]);
$cpn=$this->coupon_repository->findCouponById($cidsnl[$i]);

$siteNL->new_meals()->save($newMeal);
$cpn->new_meals()->save($newMeal);
$wkr->new_meals()->save($newMeal);
$siteNL->calendars()->save($newCalendar);
$cpn->calendars()->save($newCalendar);
$wkr->calendars()->save($newCalendar);
$siteNL->processing_titles()->save($newTitle);
$cpn->processing_titles()->save($newTitle);
$wkr->processing_titles()->save($newTitle);
}
}
//In case the arrays have members that are identical
$workerIds=array_values(array_intersect($wids,$workIds));
foreach($workerIds as $workerId){
// for every worker id find his corresponding coupon id and put it in an array 
$couponIds[]=$this->worker_repository->findCouponId($workerId, $request->input('month'), $request->input('meal'));
$lunchCouponIds[]=$this->worker_repository->findCouponId($workerId, $request->input('month'), 'lunch');
}

for($i=0;$i<count($workerIds);$i++){
$date=$request->input('date');
$month=$request->input('month');
$meal=$request->input('meal');
//for every member of the workerIds and couponIds arrays find the suiting objects
$coupon1=$this->coupon_repository->findCouponById($couponIds[$i]);
$worker1=$this->worker_repository->findWorkerById($workerIds[$i]);
/*the a title object that has a title value that ends with the word lunch and has worker_id and coupon_id 
foreign keyes equal to the ones passed*/
$title1=$this->title_repository->returnTitleByIdsAndLunch("lunch",$workerIds[$i],$lunchCouponIds[$i]);
$string=$title1->title;
$array=explode(" ",$string);
$array=array_slice($array,0,-1);
$string=implode(" ", $array);
$string=$string." ".$meal;
$new_meal=new NewMeal;
$new_meal->meal=$meal;
$new_title=new ProcessingTitle;
$new_title->title=$string;
$new_calendar=new Calendar;
$new_calendar->date=$date;
$new_calendar->month=$month;
$siteId=$title1->construction_site_id;
$site=$this->site_repository->findSiteByID($siteId);
$site->new_meals()->save($new_meal);
$coupon1->new_meals()->save($new_meal);
$worker1->new_meals()->save($new_meal);
$site->calendars()->save($new_calendar);
$coupon1->calendars()->save($new_calendar);
$worker1->calendars()->save($new_calendar);
$site->processing_titles()->save($new_title);
$coupon1->processing_titles()->save($new_title);
$worker1->processing_titles()->save($new_title);

}
}
//*
public function returnCouponsAndWorkersAttachedToTitle($title) {
$titleObject=$this->title_repository->returnTitleRecord($title);

foreach($titleObject as $title){
$cids[]=$title->coupon_id;
$wids[]=$title->worker_id;
}
for($i=0;$i<count($cids);$i++){
$coupons[]=$this->coupon_repository->findCouponById($cids[$i]);
$workers[]=$this->worker_repository->findWorkerById($wids[$i]);
}
for($i=0;$i<count($coupons);$i++){
$couponNumbers[]=$coupons[$i]->coupon_number;
$workerAccounts[]=$workers[$i]->accountNumber;
$workerNames[]=$workers[$i]->workerName;
$departmentIds[]=$workers[$i]->department_id;
}

foreach ($departmentIds as $did) {
$object=$this->department_repository->findDepartmentById($did);
$departmentNames[]=$object->departmentName;
} 
return $array=[$couponNumbers, $workerAccounts, $workerNames, $departmentNames];
}
//*
public function detachDataFromConstructionSite($request){
/*I'm decoding the json string of worker's coupon numbers, names and account numbers and turning 
it into an array of separate worker's credentials. The members of that array are strings.*/
$array=json_decode($request->input('secret'));
foreach($array as $member){
//Every member of the array I'm further deconstructing it and transforming it into a sub-array
$arrayTwo[]=explode(" ",$member);
}
//Retrieve the value of the hidden input field title in the Processing.plist view
$title=$request->input('title');
$arrayTitle=explode(" ",$title);
$meal=end($arrayTitle);
$date=reset($arrayTitle);
$dateArray=explode("-",$date);
$months=["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July",
"08"=>"August","09"=>"September","10"=>"October", "11"=>"November","12"=>"December"];
for($i=0;$i<count($arrayTwo);$i++){
//for every member of the array, on the base of the data that it contains the coupon and the worker ids
$wids[]=$this->worker_repository->returnWorkersId($arrayTwo[$i][1],$arrayTwo[$i][2]);}
foreach($wids as $wid){
$cids[]=$this->worker_repository->findCouponId($wid, $months[$dateArray[1]], $meal);}
for($i=0;$i<count($cids);$i++){
/*then delete those rows, that contain theese foreign keys, from the database tables processing titles, 
new meals and calendars*/
$this->title_repository->DeleteTitleRecord($cids[$i],$wids[$i]);
$this->calendar_repository->DeleteCalendarRecord($cids[$i],$wids[$i]);
$this->new_meal_repository->DeleteNewMealRecord($cids[$i],$wids[$i]);
}
}
//*
public function processEditData($request){
/*I'm decoding the json string of worker's coupon numbers, names and account numbers and turning 
it into an array of separate worker's credentials. The members of that array are strings.*/
$array=json_decode($request->input('secret'));
foreach($array as $member){
$arrayTwo[]=explode(" ",$member);
}
return $arrayTwo;
}
//*
public function transformArrayToString($array){
foreach($array as $element){
//each element of the array is turned into a string and put into a string array
$string[]=implode(" ",$element);
}
/*then that string array is transformed into one big string, waiting to be set as value of the hidden input 
field in the edit view, then passed to updateWithSubmitedData($request) method, in this class, for further processing*/
$string=implode("|",$string);
return $string; 
}
//*
public function returnDateAndMeal($request){
$array=explode(" ",$request->input('title'));
$arrayOne=[reset($array), end($array)];
$month=$this->calendar_repository->findMonth($arrayOne[0]);
$arrayOne=[reset($array), end($array), $month];
return $arrayOne;
}
//*
public function updateWithSubmitedData($request){
//This is the arrray of worker credentials that I've turned into string
$string=$request->input('string');
//Now I'm returning it as an array
$array=explode('|',$string);
foreach($array as $member){
//Also each member of that array now is a subarray, not string
$arrayOne[]=explode(" ",$member);
}
for($i=0;$i<count($arrayOne);$i++){
$wids[]=$this->worker_repository->returnWorkersId($arrayOne[$i][1],$arrayOne[$i][2]);}
$title=$request->input('title');
$arrayTitle=explode(" ",$title);
$meal=end($arrayTitle);
$date=reset($arrayTitle);
$dateArray=explode("-",$date);
$months=["01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July",
"08"=>"August","09"=>"September","10"=>"October", "11"=>"November","12"=>"December"];
foreach($wids as $wid){
$cids[]=$this->worker_repository->findCouponId($wid, $months[$dateArray[1]], $meal);}

for($i=0;$i<count($cids);$i++){
//After I've found the coupon and worker ids for the data that at first I received as string in this method
//Now I'm deleting the rows from the tables Calendars, NewMeals and ProcessingTitles that contain those foreign keyes
$this->title_repository->DeleteTitleRecord($cids[$i],$wids[$i]);
$this->calendar_repository->DeleteCalendarRecord($cids[$i],$wids[$i]);
$this->new_meal_repository->DeleteNewMealRecord($cids[$i],$wids[$i]);
}
/*Then I repeat the most of the same procedure from above using the freshly entered new data from the edit form. Since I'll
find the $wids and $cids, I'm going to find every coupon and worker object for the id given. For each of the coupon and worker 
objects plus the  retrieved construction site object I'm going to create relations with the new instances of 
Calendar, ProcessingTitle and NewMeal models and save them into the database*/
$meal=$request->input('meal');
$date=$request->input('date');
$month=$request->input('month');
$siteName=$request->input('siteName');
$title=$date." ".$siteName." ".$meal;
$accountNumbers=$request->input('an');
$workerNames=$request->input('wn');
$wids=[];
$cids=[];
for($i=0;$i<count($accountNumbers);$i++){
$wids[]=$this->worker_repository->returnWorkersId($accountNumbers[$i],$workerNames[$i]);}
foreach($wids as $wid){
$cids[]=$this->worker_repository->findCouponId($wid,$month,$meal);}
for($i=0;$i<count($wids);$i++){
$coupons[]=$this->coupon_repository->findCouponById($cids[$i]);
$workers[]=$this->worker_repository->findWorkerById($wids[$i]);}
for($i=0;$i<count($workers);$i++){
$site=$this->site_repository->findSiteByName($siteName);
$newMeal= new NewMeal;
$newMeal->meal=$meal;
$site->new_meals()->save($newMeal);
$coupons[$i]->new_meals()->save($newMeal);
$workers[$i]->new_meals()->save($newMeal);
$newCalendar= new Calendar;
$newCalendar->date=$date;
$newCalendar->month=$month;
$site->calendars()->save($newCalendar);
$coupons[$i]->calendars()->save($newCalendar);
$workers[$i]->calendars()->save($newCalendar);
$newTitle= new ProcessingTitle;
$newTitle->title=$title;
$site->processing_titles()->save($newTitle);
$coupons[$i]->processing_titles()->save($newTitle);
$workers[$i]->processing_titles()->save($newTitle);
}
}

}












