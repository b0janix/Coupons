<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\HomeServiceInterface;

class HomeController extends Controller
{

protected $hs;

function __construct(HomeServiceInterface $hs)  {
$this->hs=$hs;
  }

public function welcome(){
$editor=$this->hs->retrieveEditorObject();
$admin=$this->hs->retrieveAdminObject();
return view('Home.home', compact('editor','admin'));
}

}
