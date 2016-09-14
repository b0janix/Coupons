<?php

namespace App\Services;

use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;


class AdminPanel implements AdminPanelInterface {

protected $role;
protected $user;

function __construct(RoleRepositoryInterface $role, UserRepositoryInterface $user)  {
$this->role=$role;
$this->user=$user;
}
//returns the names and the emails of those users that have editor role
public function getEditorsNamesAndMails(){
$ids=$this->role->returnEditorsUserIds();
if($ids==null){
$names=[];
$emails=[];
return [$names,$emails];
}
foreach($ids as $id){
$ids[]=$id->user_id;
}
foreach($ids as $id){
if(is_integer($id)==true){
$array[]=$id;
}
}
foreach($array as $member){
$editor=$this->user->findUserById($member);
$names[]=$editor->name;
$emails[]=$editor->email;
}
return [$names,$emails];
}
//returns the names and the emails of those users who don't have roles
public function getRegularsNamesAndMails(){
//first return all users
$users=$this->user->returnAllUsers();
$regulars=[];
foreach($users as $user){
//if the collection of roles attached to this user is equal to 0 then put that user into the regulars array
if(count($user->roles)==0){
$regulars[]=$user;
}
}
if($regulars==[]){
$names=[];
$emails=[];
}
foreach($regulars as $regular){
//retrieve the names and mails of every user and return them
$names[]=$regular->name;
$emails[]=$regular->email;
}
return [$names, $emails];
}
//detach editor role from the selected user
public function detachSelectedEditors($request){
$array=json_decode($request->input('secret'));
foreach ($array as $member) {
$arrayTwo[]=explode(" ",$member);
}
foreach($arrayTwo as $member){
$emails[]=end($member);
}
foreach($emails as $email){
$users[]=$this->user->findSingleUserByEmail($email);
}
foreach($users as $u){
foreach($u->roles as $role){
$id=$role->pivot->role_id;
$u->roles()->detach($id);
}
}
}
//attach editor role to the selected users
public function attachSelectedUsers($request){
$array=json_decode($request->input('hidden'));
foreach ($array as $member) {
$arrayTwo[]=explode(" ",$member);
}
foreach($arrayTwo as $member){
$emails[]=end($member);
}
foreach($emails as $email){
$users[]=$this->user->findSingleUserByEmail($email);
}
foreach($users as $u){
$u->roles()->attach(1);
}
}

public function Admins(){
$admins=$this->user->returnAdmins();
foreach ($admins as $admin){
$names[]=$admin->name;
$emails[]=$admin->email;
}
return [$names,$emails];
}

}