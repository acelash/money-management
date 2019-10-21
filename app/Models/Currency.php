<?php

namespace App\Models;

class Currency extends Elegant
{
    protected $table = 'currencies';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
        'ord'
    ];

    public function rate()
    {
        return $this->hasOne(
            'App\Models\CurrencyRate',
            'currency_id',
            'id'
        );
    }
}
