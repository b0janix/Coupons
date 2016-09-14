<?php

namespace App\Validators;

use Validator;

class UserValidator {

  public function validate($data){

 return Validator::make($data, [
  'name' => 'required|min:3',
  'email' => 'required|email|unique:users,email',
  'password'=>'required|alpha_num|min:6|confirmed']);
  }

public function validateUser($request){
$data=$request->only(['name','email','password','password_confirmation']);

$validator=$this->validate($data);
if (count($validator->invalid())>0) {
return $validator;
        }
return[];

}

}