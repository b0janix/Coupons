<?php 

namespace App\Repositories;

use App\User;
use DB;

class UserRepository implements UserRepositoryInterface {
  
protected $user;

function __construct(User $user){
$this->user=$user;
  }
//*
//I'm using the create method which accepts array of data as an argument
public function saveUser($input) {
return $this->user->create($input);
  }
//*
public function updateUser($email, $db)  {
$this->user->where('email', $email)->update($db);
  }
//*
public function findUserByEmail($email) {
return $this->user->where('email', $email)->first();
  }
//*
public function findOneHash($email) {
return $this->user->where('email', $email)->value('recover_hash');}
//*
public function findName($email) {
return $this->user->where('email', $email)->value('name');
  }
//*
public function findUserById($id){
return $this->user->where('id', $id)->first();
}
//*
public function findSingleUserByEmail($email){
return $this->user->with('roles')->where('email', $email)->first();
}
//*
public function returnAllUsers(){
return $this->user->with('roles')->get();
}
//*
public function returnAdmins(){
return $this->user->with('roles')->join('role_user','users.id','=','role_user.user_id')->where('role_user.role_id','=',2)->get();
}

}