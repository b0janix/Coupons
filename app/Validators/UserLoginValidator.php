<?php

namespace App\Validators;

use Validator;

class UserLoginValidator {

  public function validate($data){

 return Validator::make($data, [
  'email' => 'required|email',
  'password'=>'required|alpha_num|min:6']);
  }

public function validateUser($request){
$data=$request->only(['email','password']);

$validator=$this->validate($data);
if (count($validator->invalid())>0) {
return $validator;
        }
return[];

}

}