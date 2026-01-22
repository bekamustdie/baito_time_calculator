<?php
namespace App\Services;

use App\Models\User;

class UsersService{

	public function getAllUsers($query, $request) {
		return $query->get();
	}
	
	public function createUser($query,array $data) {
		dd($data);
		// $exists = $query->where()
	}
}