<?php

namespace App\Models;

class FinancialResource extends Elegant
{
    protected $table = 'financial_resources';
    protected $fillable = [
        'currency_id',
        'user_id',
        'value',
        'name'
    ];

    public function currency()
    {
        return $this->hasOne(
            'App\Models\Currency',
            'id',
            'currency_id'
        );
    }

    public function user()
    {
        return $this->hasOne(
            'App\User',
            'id',
            'user_id'
        );
    }
}
