<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExchangeRatesResource;
use App\Currency;
use App\ExchangeRates;
use Illuminate\Support\Facades\Http;

class ExchangeRatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $create_dt          =date('Y-m-d H:i:s');
        $response           =Http::get('https://api.exchangeratesapi.io/latest?base=RUB');
        $exchangeRatesValues=$response->json()['rates'];
        foreach($exchangeRatesValues as $currencyName=>&$exchangeRateValue){
            if(empty($currencyName) || !is_numeric($exchangeRateValue) || $exchangeRateValue===0){
                continue;
            }

            $exchangeRate=Currency::firstOrCreate([
                'name'=>$currencyName,
                'code'=>$currencyName,
            ]);

            $exchangeRatesNew             =new ExchangeRates();
            $exchangeRatesNew->currency_id=$exchangeRate->id;
            $exchangeRatesNew->value      =1/$exchangeRateValue;
            $exchangeRatesNew->created_at =$create_dt;
            $exchangeRatesNew->save();
        }

        return ExchangeRatesResource::collection(ExchangeRates::all()->where('created_at', '=', $create_dt));
    }
}
