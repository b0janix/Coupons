<?php

namespace App\Services;

use Mail;
use App\Repositories\UserRepositoryInterface;

class ForgotPassword implements ForgotPasswordInterface {

protected $user_repository;

  function __construct(UserRepositoryInterface $user_repository)  {
$this->user_repository=$user_repository;
  }

public function sendHashedString($email, $hash)  {
$user=$this->user_repository->findUserByEmail($email);
//return a single value of the field name from the table users, where the value of email field is equal to the value of $email 
$name=$this->user_repository->findName($email);

if (is_null($user))  {
//if the user couldn't be found set up a fail message in a session
session()->flash('message','We couldn\'t find that user.');
return redirect()->route('fp.create');
  }
  else  {
//create a 80 character random string using laravel's helper function str_random
$identifier=str_random(80);
//hash it
$hashed_identifier=$hash->hashing($identifier);
//user_repository instance of the class with the same name, calls an updateUser method from the same class
//this method accepts email as an argument, who serves as an unique value by which the the wanted user will be retrieved 
//when the user is found, we are updating the recover_hash field from the table users with the value of the hashed string
$this->user_repository->updateUser($email, ['recover_hash'=>$hashed_identifier]);
//I'm using Laravel's Mail facade,.It is wrapped around PHP mailer class
//The first argument is the view to which the mail will be sent
//The second is an array of get parameters
//The third is a callback function with an argument $m that represents the message object
//i'm also passing the $email and the $name variables, from the code above, for the needs of the email message object
Mail::send('Email.template', ['email'=>$email,'identifier'=>$identifier], function($m) use ($email,$name) {
$m->to($email, $name)->subject('Recover your password');});
//at the end i'm creating a flash message which will appear to the visitor after the mail will be sent
session()->flash('the_message','We\'ve emailed you instructions to reset your password');
      }
    }
  }