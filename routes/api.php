<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoStreamingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource("video", VideoStreamingController::class);
Route::get("stream/{uid}", [VideoStreamingController::class, 'streamVideo']);
Route::get("download/{uid}", [VideoStreamingController::class, 'fileVideo']);
