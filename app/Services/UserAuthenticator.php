<?php

namespace App\Services;

  use App\Repositories\UserRepositoryInterface;
  use Auth;

class UserAuthenticator implements UserAuthenticatorInterface {

protected $user_repository;

  function __construct(UserRepositoryInterface $user_repository){
    
    $this->user_repository=$user_repository;
    
}
//*
  public function registerUsers($hash, $request){
//The instance $hash calls a method from the AppHasher class that executes the hashing of the password
//Laravel has a Hash facade and a make method that performs a bcrypt hashing
$hashedPassword=$hash->hashing($request->input('password'));
//after the passwored is hashed I'm calling a method from the UserRepository class that persists the user to the database
$this->user_repository->saveUser(['name'=>$request->input('name'),'email'=>$request->input('email'),
'password'=>$hashedPassword]);

  }
  
//*
public function loginUsers($request)  {
//I'm using Laravel's Auth facade
/*The attempt method accepts an array of key / value pairs as its first argument. The values in the array 
will be used to find the user in your database table. So the user will be retrieved by the value of the email
 column. If the user is found, the hashed password stored in the database will be compared with the hashed 
 password value passed to the method via the array. If the two hashed passwords match an authenticated 
 session will be started for the user. The attempt method will return true if authentication was successful. 
 Otherwise, false will be returned.*/
if (Auth::attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')]))  {
return redirect()->intended('/');
}

else{
//Else put a failure message into session and redirect the visitor back to the "Sign in" form, where you'll retrieve the message
session()->flash('flash_message','Username/Password don\'t match.');

return back()->withInput();}
    
  }
//*
public function logoutUsers() {
/*To log users out of the application, I use the logout method on the Auth facade. This will clear the authentication information in the user's session:*/
Auth::logout();

  }

}