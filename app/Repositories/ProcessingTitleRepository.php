<?php

namespace App\Repositories;

use App\ProcessingTitle;

class ProcessingTitleRepository implements ProcessingTitleRepositoryInterface {

  protected $processingTitle;

function __construct(ProcessingTitle $processingTitle)  {
    $this->processingTitle=$processingTitle;
  }
/*
public function returnTheLastTitle(){

return $this->processingTitle->orderBy('id','desc')->first();

  }*/

//*
public function returnTitles(){
return $this->processingTitle->orderBy('id','desc')->get();
}

//*
public function returnTitleRecord($title){
return $this->processingTitle->where('title','=',$title)->get();
}
//*
public function returnTitleByIdsAndLunch($meal,$workerId, $couponId){
return $this->processingTitle->where('title','LIKE',"%".$meal)->where('worker_id','=',$workerId)
->where('coupon_id','=',$couponId)->latest()->first();
}
//*
public function DeleteTitleRecord($cid,$wid){
$this->processingTitle->where('coupon_id','=',$cid)->where('worker_id','=',$wid)->forceDelete();
}

}