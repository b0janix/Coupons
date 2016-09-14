<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\UserAuthenticatorInterface;
use App\Validators\UserLoginValidator;

class LoginController extends Controller
{
    //

protected $authenticator;

  function __construct(UserAuthenticatorInterface $authenticator) {
    //
    $this->authenticator=$authenticator;
    $this->middleware('signedIn');
  }
  public function create()
    {
        //
  return view('Login.login');
    }

  public function store(Request $request, UserLoginValidator $v)
    {
$validator=$v->validateUser($request);

if ($validator!=[]) {
return redirect()->route('login.create')
->withErrors($validator)
->withInput();
  }

return $this->authenticator->loginUsers($request);
    }
}


