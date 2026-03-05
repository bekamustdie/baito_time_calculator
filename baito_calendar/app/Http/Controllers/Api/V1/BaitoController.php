<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostBaitoRequest;
use App\Http\Resources\BaitoResource;
use App\Services\BaitosService;
use App\Models\Baito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class BaitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private BaitosService  $baitosService){}

    public function index(Request $request)
    {
        $baitos = $request->user()->baito;
        return BaitoResource::collection($baitos);
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
    public function show(Baito $baito)
    {
        Gate::authorize('view', $baito);
        return response()->json(new BaitoResource($baito));
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
    public function destroy(Baito $baito)
    {
        Gate::authorize('delete', $baito);
        $baito->delete();
        return response()->noContent(204);
    }
}
