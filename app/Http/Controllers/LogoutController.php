<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\UserAuthenticatorInterface;

class LogoutController extends Controller
{
protected $autenticator;

  function __construct(UserAuthenticatorInterface $authenticator) {
    
    $this->authenticator=$authenticator;
  }

  public function getLogout()
    {
        //
 $this->authenticator->logoutUsers();
//After the logout redirect the visitor to the home page
 return redirect('/');
    }
}
