<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Currency;

class ExchangeRates extends Model
{
    protected $fillable=['currency_id', 'value'];
    public $timestamps=true;

    public function ExchangeRate(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
