<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\RoleRepositoryInterface;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    protected $user;
    protected $role;

    public function __construct(UserRepositoryInterface $user, RoleRepositoryInterface $role)
    {
$this->user=$user;
$this->role=$role;
    }
//Policies are classes that organize authorization logic around a particular model or resource
//The policies are being registered into the AuthServiceProvider
public function allow(){
//this method returns the user ids of the users who have role with the name Editor
$userIds=$this->role->returnEditorsUserIds()->toArray();
foreach($userIds as $userId ){
$ids[]=$userId['user_id'];
}
foreach($ids as $id){
//for every user id compare whether the value of the returned id from the database 
//is equal to the value of the id of the curently logged in or authenticated user
if($id==Auth::id()){
//if it is equal it will return true so the method denies of the Gate facade will receive a boolean true
//so it means it won't denie the access of the user, with a role that has a property name with value Editor,
//to the page which access is protected by the authorization logic in the allow method of the RolePolicy   
return true;
}
}
}

public function manage(){
//this method returns the user ids of the users who have role with the name Editor
$userIds=$this->role->returnAdminsUserIds()->toArray();
foreach($userIds as $userId ){
$ids[]=$userId['user_id'];
}
foreach($ids as $id){
//for every user id compare whether the value of the returned id from the database 
//is equal to the value of the id of the curently logged in or authenticated user
if($id==Auth::id()){
//if it is equal it will return true so the method denies of the Gate facade will receive a boolean true
//so it means it won't denie the access of the user, with a role that has a property name with value Administrator,
//to the page which access is protected by the authorization logic in the allow method of the RolePolicy
return true;
}
}
}

}
