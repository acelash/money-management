<?php

namespace App\Models;

class CriptoInvestition extends Elegant
{
    protected $table = 'cripto_investitions';
    protected $fillable = [
        'resource_id',
        'user_id',
        'investition_value',
        'ammount_purchased',
        'comment'
    ];

    public function resource()
    {
        return $this->hasOne(
            'App\Models\CriptoResource',
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

    public function getProfitRate(){
        $currentPrice = $this->resource->currency->rate->rate;
        $currentValue = $currentPrice * $this->ammount_purchased;
        return $currentValue / $this->investition_value;
    }
}
