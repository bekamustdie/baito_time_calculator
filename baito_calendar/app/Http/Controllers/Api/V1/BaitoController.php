<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostBaitoRequest;
use App\Http\Resources\BaitoResource;
use Illuminate\Http\Request;
use App\Services\BaitosService;
use App\Models\Baito;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private BaitosService  $baitosService){}

    public function index(User $user)
    {
        $data = $user->baito()->get();
        // $all_baito = $this->baitosService->getAllBaitos($query, $request);
        return BaitoResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostBaitoRequest $request, User $user)
    {
        $baito = $user->baito()->create($request->validated());
        return response()->json(new BaitoResource($baito));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
