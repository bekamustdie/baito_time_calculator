<?php
namespace App\Services;

use App\Models\User;

class UsersService{

	public function getAllUsers($query, $request) {
		return $query->get();
	}
	
	public function createUser(array $data) {
		return User::create($data);
	}
}