<?php

namespace App\Repositories;

use App\Calendar;

class CalendarRepository implements CalendarRepositoryInterface {

  protected $calendar;

function __construct(Calendar $calendar)  {
    $this->calendar=$calendar;
  }

//*
public function returnCalendarObjects($date,$month){
return $this->calendar->where('date','=',$date)->where('month','=',$month)->get();
}

/*public function returnObjectByDate($date){
return $this->calendar->where('date','=',$date)->first();
}*/
//*
public function DeleteCalendarRecord($cid,$wid){
$this->calendar->where('coupon_id','=',$cid)->where('worker_id','=',$wid)->forceDelete();
}

public function findMonth($date){
return $this->calendar->where('date','=',$date)->first()->month;
}

}