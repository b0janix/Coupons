<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\AdminPanelInterface;
use App\Services\AccessControlInterface;

class AdminPanelController extends Controller
{

protected $ap;
protected $ac;

function __construct(AdminPanelInterface $ap, AccessControlInterface $ac) {
$this->ap=$ap;
$this->ac=$ac;
}

public function index(){
$this->ac->checkForAdminPermission();
//get the names and mails of all editors
$array=$this->ap->getEditorsNamesAndMails();
//get the names and mails of all users without permissions
$regulars=$this->ap->getRegularsNamesAndMails();
//get the names and the mails of all admins
$admins=$this->ap->Admins();
return view('Panel.admin',compact('array','regulars','admins'));
}

public function remove(Request $request){
$this->ap->detachSelectedEditors($request);
return redirect()->route('panel');
}

public function add(Request $request){
$this->ap->attachSelectedUsers($request);
return redirect()->route('panel');
}

}
