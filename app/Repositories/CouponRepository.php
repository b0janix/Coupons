<?php

namespace App\Repositories;

use App\Coupon;
use DB;

class CouponRepository implements CouponRepositoryInterface {

  protected $coupon;

function __construct(Coupon $coupon)  {
    $this->coupon=$coupon;
  }
//*
public function relateCouponsToWorkers($input_c,$idDB,$year,$month,$date, $meal,$title){
//Creates the coupon in the database
$new=$this->coupon->create($input_c);
//Attaches the worker's id and the values of the fields from the pivot table 
$new->workers()->attach($idDB, ['year'=>$year,'month'=>$month,'date'=>$date,'meal'=>$meal,'title'=>$title]);}

//*
public function returnCouponsWithWorkers(){
//returns all coupons that are related with workers
return $this->coupon->with('workers')->get();
}

//Returns all the coupons with the given coupon number, that are paired with workers
public function returnCouponsByNumber($input_c){
 return $this->coupon->with('workers')->where('coupon_number','=',$input_c)->get();
}

//*
public function findCouponById($id){
return $this->coupon->where('id','=',$id)->first();
  }

//*
public function findCouponByNumberAutocomplete($term, $month, $meal){
return $this->coupon->with('workers')->join('coupon_worker','coupons.id','=','coupon_worker.coupon_id')->where('coupon_worker.month','=', $month)->where('coupon_worker.meal','=', $meal)->where('coupons.coupon_number','like', '%'.$term.'%')->first();
  }
//*
public function  findCouponByNumberFiltered($number, $month, $meal){
/*return the coupon object that has month and meal values in the pivot coupon_worker table and that those values are equal 
to the ones that we are fetching as arguments in this method. Identical is the case of the coupon number field. The point 
is to check whether that coupon with that coupon numebr for the specified month and meal is already stored in the database  */
return $this->coupon->with('workers')->join('coupon_worker','coupons.id','=','coupon_worker.coupon_id')->where('coupon_worker.month','=', $month)->where('coupon_worker.meal','=', $meal)->where('coupons.coupon_number','=', $number)->first();
}

//*
public function returnCouponsId($id,$meal){
$result=$this->coupon->join('new_meals','coupons.id','=','new_meals.coupon_id')->where('new_meals.worker_id','=',$id)
->where('new_meals.meal','=',$meal)->where('coupons.created_at','=',date('Y-m-d'))->first();
return $result;
}

public function delete($ids){
DB::table('coupons')->whereIn('id',$ids)->delete();
}

/*
public function getDataForTitle()  {
return $this->coupon->with('workers')->join('coupon_worker','coupons.id','=','coupon_worker.coupon_id')->orderBy('time','desc')->select('coupons.*')->first();
}*/

/*
public function getMultipleDataForTitle($x){
return $this->coupon->with('workers')->orderBy('id','desc')->take($x)->get();
}

public function getCouponIds($x){
$coupons=$this->coupon->orderBy('id','desc')->take($x)->get();
foreach($coupons as $coupon){
$ids[]=$coupon->id;
}
return $ids;
}

public function returnCouponByNumber($input_c){
 return $this->coupon->with('workers')->where('coupon_number','=',$input_c)->first();
}*/

/*
public function findLastCoupon()  {
return $this->coupon->with('workers')->join('coupon_worker','coupons.id','=','coupon_worker.coupon_id')->orderBy('time','desc')->select('coupons.*')->first();}

public function findLastCouponMultipleData($x){
return $this->coupon->with('workers')->orderBy('id','desc')->take($x)->first();
}

public function returnAllCoupons()  {
return $this->coupon->with('titles')->orderBy('id','desc')->get();
}

public function findSpecifiedCoupons($id) {
return $this->coupon->with('workers')->findOrFail($id);
}*/

/*
public function returnCouponsWithProcessingTitle() {

return $this->coupon->with('construction_sites')->get();

}

public function findSingleCoupon($id){
return $this->coupon->findOrFail($id);
}

public function returnCouponsWithProcessingTitleByCouponNumber($input) {
return $this->coupon->with('construction_sites')->where('coupon_number','=',$input)->first();
}

public function returnClickedTitleC($title){
return $this->coupon->join('construction_site_coupon','coupons.id','=','construction_site_coupon.coupon_id')
->where('title','=',$title)->select('construction_site_coupon.title')->first();
}

public function queryCouponByNumberAndTitle($title, $coup_num){
return $this->coupon->join('construction_site_coupon','coupons.id','=','construction_site_coupon.coupon_id')
->where('construction_site_coupon.title','=',$title)->where('coupons.coupon_number','=',$coup_num)->select('coupons.id')->first();
}

public function queryCouponByNumberAndId($number,$id){
return $this->coupon->where('coupon_number','=',$number)->where('id','=',$id)->first();
}

public function returnCouponByTidInput($tid){
return $this->coupon->join('coupon_title','coupons.id','=','coupon_title.coupon_id')->where('coupon_title.title_id','=',$tid)
->select('coupons.*')->get();
}

public function findTitleByIds($id,$title){
return $this->coupon->join('construction_site_coupon','coupons.id','=','construction_site_coupon.coupon_id')
->where('construction_site_coupon.coupon_id','=',$id)->where('construction_site_coupon.title','=',$title)
->select('construction_site_coupon.title')->get()->toArray();}

public function findIdsByTitle($title){
return $this->coupon->join('construction_site_coupon','coupons.id','=','construction_site_coupon.coupon_id')
->where('construction_site_coupon.title','=',$title)
->select('construction_site_coupon.coupon_id')->get()->toArray();}

public function returnCouponWorkerPivot($id){
return $this->coupon->join('coupon_worker','coupons.id','=','coupon_worker.coupon_id')->where('coupon_worker.coupon_id','=',$id)
->select('coupon_worker.*')->first();
}*/



}

