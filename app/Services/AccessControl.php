<?php

namespace App\Services;

use Gate;
use App\Repositories\RoleRepositoryInterface;


class AccessControl implements AccessControlInterface {

protected $role;

function __construct(RoleRepositoryInterface $role)  {
$this->role=$role;}

public function checkForPermission(){
//finds the object witn name editor as an istance of the Role model
$editor=$this->role->findEditorRole();
//I'm using Laravel's Gate facade for perfomring authorizing actions
//If the method denies returns true for the method allow from the RolePolicy policy and the editor object
if (Gate::denies('allow',$editor)){
//the abort function will throw a HTTP exception which will be rendered by the exception handler
abort('403','Unauthorized access');
 }
}
//-||-
public function checkForAdminPermission(){
$admin=$this->role->findAdminRole();
if (Gate::denies('manage',$admin)){
abort('403','Unauthorized access');
 }
}

}


