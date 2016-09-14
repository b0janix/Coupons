<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ResetPasswordInterface;
use App\Validators\ResetPasswordValidator;
use App\Validators\AppHasher;

class ResetPasswordController extends Controller
{
protected $reset_password;

  function __construct(ResetPasswordInterface $reset_password)  {
    //
    $this->reset_password=$reset_password;
    $this->middleware('signedIn');
  }

    public function create($email, $identifier, AppHasher $hash)
    {
//this method accepts $email and $identifier parameters that were sent by a GET request from the email link
//also accepts instance of hash
      $check=$this->reset_password->verifyToken($email, $identifier, $hash);

    if($check==true){
//If the method returns true pass the $email and $identifier to the view
      return view('Email.new_password', compact('email', 'identifier'));
      }  
    else{ 
      session()->flash('message_two','Something has happend. You can\'t change your password.');
      return redirect('/');
      }
    }

public function store(ResetPasswordValidator $v, Request $request, AppHasher $hash)

    {

      $validator=$v->validateNewPassword($request);

  if ($validator!=[]) {
//if the validator fails redirect the user to the previous route, so that is why we needed $email and $identifier
//to be sent back as parameters, because the route requires those two parameters
  return redirect()->route('reset.create',['email'=>$request->input('email'), 'identifier'=>$request->input('identifier')])
  ->withErrors($validator);
    }
//if the validator doesen't fail call the change password method from the ResetPassword class
     $this->reset_password->changeThePassword($request,$hash);
    return redirect('/');
    }

}
