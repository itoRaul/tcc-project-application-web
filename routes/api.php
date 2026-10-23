<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::post('/readings', [ApiController::class, 'store']);
