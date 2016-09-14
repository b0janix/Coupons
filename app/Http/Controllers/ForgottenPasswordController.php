<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ForgotPasswordInterface;
use App\Validators\AppHasher;
use App\Validators\ResetValidator;

class ForgottenPasswordController extends Controller
{
protected $recovery;
  function __construct(ForgotPasswordInterface $recovery)  {
    $this->recovery=$recovery;
    $this->middleware('signedIn');
  }

  public function create()
    {
        //
    //view for the 
    return view('Email.email');
    }

    public function store(ResetValidator $v, Request $request, AppHasher $hash)

    {

    $validator=$v->validateUser($request);

  if ($validator!=[]) {
    return redirect()->route('fp.create')
    ->withErrors($validator)
    ->withInput();
      }
//I'm sending the hash and request instances as arguments to the method of the ForgottenPassword class
 $this->recovery->sendHashedString($request->input('email'), $hash);
return redirect()->route('fp.create');
    }
}
