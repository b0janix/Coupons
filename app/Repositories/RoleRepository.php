<?php

namespace App\Repositories;

use App\Role;
use Illuminate\Support\Facades\Auth;


class RoleRepository implements RoleRepositoryInterface {

  protected $role;

function __construct(Role $role)  {
    $this->role=$role;
  }
//*
public function findEditorRole(){
return $this->role->where('title','Editor')->first();
}
//*
public function returnEditorsUserIds(){
return $this->role->join('role_user','roles.id','=','role_user.role_id')->where('roles.title','=','Editor')
->select('role_user.user_id')->get();
}
//*
public function findAdminRole(){
return $this->role->where('title','Administrator')->first();
}

public function returnAdminsUserIds(){
return $this->role->join('role_user','roles.id','=','role_user.role_id')->where('roles.title','=','Administrator')
->select('role_user.user_id')->get();
}

}