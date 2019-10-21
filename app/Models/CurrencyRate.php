<?php

namespace App\Models;

class CurrencyRate extends Elegant
{
    protected $table = 'currency_rates';
    protected $fillable = [
        'currency_id',
        'currency2_id',
        'rate'
    ];
    protected $dates =['updated_at'];

    public function currency()
    {
        return $this->hasOne(
            'App\Models\Currency',
            'id',
            'currency_id'
        );
    }

    public function currency2()
    {
        return $this->hasOne(
            'App\Models\Currency',
            'id',
            'currency2_id'
        );
    }
}
