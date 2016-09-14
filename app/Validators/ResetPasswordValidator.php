<?php
namespace App\Validators;

use Validator;

class ResetPasswordValidator {

  public function validate($data){

return Validator::make($data, [
'password'=>'required|alpha_num|min:6|confirmed',]);
  }

public function validateNewPassword($request){
$data=$request->only(['password','password_confirmation']);
$validator=$this->validate($data);
if (count($validator->invalid())>0) {
return $validator;
        }
return[];
}

}