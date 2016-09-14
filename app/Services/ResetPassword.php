<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class ResetPassword implements ResetPasswordInterface {

protected $user_repository;



function __construct(UserRepositoryInterface $user_repository){
$this->user_repository=$user_repository;
  }
//*
public function verifyToken($email, $identifier, $hash)  {
//find the user object by the $email passed
  $user=$this->user_repository->findUserByEmail($email);
//find the value of the field recover_hash by the value of the $email passed
  $oneHash=$this->user_repository->findOneHash($email);

if($user==null)  {
//if the user is not found set up a fail flash message
session()->flash('message','We couldn\'t find that user.');
return redirect()->route('reset.create',['email'=>$email, 'identifier'=>$identifier]);}
    
//if the  value of the stored hashed identifier is null also set up a fail flash message
if($oneHash==null)  {
    session()->flash('message','We couldn\'t find that user.');
return redirect()->route('reset.create',['email'=>$email, 'identifier'=>$identifier]);
    }
//else compare the  accepted $identifier with $oneHash from the database by calling hashChecking method of the AppHasher class
//for this purpose I'm again using the Hash facade and the check method 
//what this check method does is verifying whether the passed string $identifier is identical to 
//its hashed version from the database
if($hash->hashChecking($identifier, $oneHash)===false)  {
//if returns false setup a fail flash message
    session()->flash('message_one','This isn\'t the correct user.');
return redirect()->route('reset.create',['email'=>$email, 'identifier'=>$identifier]);
    }
//else return true
return true;

  }

  public function changeThePassword($request, $hash) {
//what basically this method does here is finding the user by the provided $email value
//and updates the field password with a new hashed version of the new password that you've entered 
//in the form of the new_password view
$this->user_repository->updateUser($request->input('email'),['password'=>$hash->hashing($request->input('password')),
'recover_hash'=>null]);
//then set up a notification flash message that your password has been changed
session()->flash('global','Your password has been changed.');
  }

}