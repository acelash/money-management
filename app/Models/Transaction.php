<?php

namespace App\Models;

class Transaction extends Elegant
{
    protected $table = 'transactions';
    protected $fillable = [
        'resource_id',
        'user_id',
        'type',
        'value',
        'is_passive_income',
        'is_exchange',
        'comment'
    ];

    public function resource()
    {
        return $this->hasOne(
            'App\Models\FinancialResource',
            'id',
            'resource_id'
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
