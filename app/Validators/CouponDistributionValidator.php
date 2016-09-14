<?php

namespace App\Validators;

use Validator;

class CouponDistributionValidator {

  public function validate($data){
return  Validator::make($data, [
  'date' => 'required|date',
  'couponNumber'=>'required|numeric',
  'accountNumber'=>'required|numeric',
  'workerName' => 'required|alpha',
  'workersDepartment' => 'required|alpha'
    ]);
  }

public function validateDistributionCreation($request){
$data=$request->only(['date','couponNumber','accountNumber','workerName','workersDepartment']);

for($i=0;$i<count($data['couponNumber']);$i++){
$validator=$this->validate([$data['date'], $data['couponNumber'][$i], $data['accountNumber'][$i], $data['workerName'][$i],
$data['workersDepartment'][$i]]);
if (count($validator->invalid())>0) {
return $validator;
        }
return [];
      }
    
  
  }
}