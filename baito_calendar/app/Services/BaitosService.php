<?php
namespace App\Services;

use App\Models\User;

class BaitosService{

    

	public function getAllBaitos($query, $request) {
    
        $user = $request->user();
        dd($request);
        $baitos = $query->where('user_id',$user->id)->get();
		return $baitos;
	}
	
	public function createBaito(array $data) {
		return User::create($data);
	}
}