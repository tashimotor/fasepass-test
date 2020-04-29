<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRatesController;
use App\ExchangeRates;
use App\Http\Resources\ExchangeRatesCollection;

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


Route::get('exchange-rates', 'ExchangeRatesController@index');

Route::get('exchange-rates/history', function () {
    return new ExchangeRatesCollection(ExchangeRates::paginate());
});

