<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RegionResource::collection(Region::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $region= Region::create($request->all());
        return new RegionResource($region);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new RegionResource(Region::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $region=Region::findOrFail($id);
        $region->update($request->all());
        return new RegionResource($region);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region=Region::findOrFail($id);
        $region->delete();

        return response()->json(null, 204);
    }
}
