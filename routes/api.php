<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::apiResource('surveys', App\Http\Controllers\Api\V1\SurveyController::class);
});
