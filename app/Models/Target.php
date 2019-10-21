<?php

namespace App\Models;

use App\User;

class Target extends Elegant
{
    protected $table = 'targets';
    protected $fillable = [
        'user_id',
        'value'
    ];

    public function user()
    {
        return $this->hasOne(
            'App\User',
            'id',
            'user_id'
        );
    }

    public function getCompletedValue(){
        $completed = User::getBalanceInMainCurrency(auth()->id());

        $percent = round($completed / $this->value,2)*100;
        return $percent;
    }
}
