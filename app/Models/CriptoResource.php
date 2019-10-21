<?php

namespace App\Models;

class CriptoResource extends Elegant
{
    protected $table = 'cripto_resources';
    protected $fillable = [
        'currency_id',
        'user_id',
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
    public function amount()
    {
        return $this->hasMany(
            'App\Models\CriptoInvestition',
            'resource_id',
            'id'
        );
    }
}
