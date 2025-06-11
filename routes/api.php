<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;

Route::get('/prices', [PriceController::class, 'getPrices']);