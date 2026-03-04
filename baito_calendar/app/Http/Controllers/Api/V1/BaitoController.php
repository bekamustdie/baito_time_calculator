<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostBaitoRequest;
use App\Http\Resources\BaitoResource;
use App\Services\BaitosService;
use App\Models\Baito;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


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
    public function store(PostBaitoRequest $request)
    {
        $user = $request->user();
        $baito = $user->baito()->create($request->validated());
        return response()->json(new BaitoResource($baito));
    }

    /**
     * Display the specified resource.
     */
    public function show(BaitoController $baito)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Baito $baito, PostBaitoRequest $request)
    {
        Gate::authorize('update', $baito);
        $baito->update($request->validated());
        return response()->json(new BaitoResource($baito), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
