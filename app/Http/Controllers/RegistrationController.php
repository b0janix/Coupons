<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\UserAuthenticatorInterface;
use App\Validators\UserValidator;
use App\Validators\AppHasher;

class RegistrationController extends Controller
{
    //
protected $autenticator;

  function __construct(UserAuthenticatorInterface $authenticator) {
    
    $this->authenticator=$authenticator;
    $this->middleware('signedIn');
  }

  public function create()
    {
        //
      
      return view('Registration.register');
    }

  public function store(AppHasher $hash, Request $request, UserValidator $v)
    {
$validator=$v->validateUser($request);

if ($validator!=[]) {
return redirect()->route('register.create')
->withErrors($validator)
->withInput();
  }
 $this->authenticator->registerUsers($hash, $request);
return redirect('/');
    }
}
