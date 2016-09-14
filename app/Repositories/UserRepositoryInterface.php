<?php

namespace App\Repositories;

interface UserRepositoryInterface {

public function saveUser($input);
public function updateUser($email, $db);
public function findUserByEmail($email);
public function findOneHash($email);
public function findName($email);
public function findUserById($id);
public function findSingleUserByEmail($email);
public function returnAllUsers();
public function returnAdmins();

}