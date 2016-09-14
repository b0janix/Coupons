<?php

namespace App\Repositories;

interface CouponRepositoryInterface {
public function relateCouponsToWorkers($input_c,$idDB,$year,$month,$date, $meal,$title);
public function returnCouponsWithWorkers();
public function returnCouponsByNumber($input_c);
public function findCouponById($id);
public function findCouponByNumberAutocomplete($term, $month, $meal);
public function  findCouponByNumberFiltered($number, $month, $meal);
public function returnCouponsId($id,$meal);
}