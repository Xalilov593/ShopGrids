<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Region;
use App\Http\Resources\RegionResource;
use App\Http\Controllers\Api\RegionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('regions', RegionController::class)->names([
    'index' => 'api.regions.index',
    'store' => 'api.regions.store',
    'update' => 'api.regions.update',
    'destroy' => 'api.regions.destroy',
    'show' => 'api.regions.show',
]);

