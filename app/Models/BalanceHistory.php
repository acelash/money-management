<?php

namespace App\Models;

class BalanceHistory extends Elegant
{
    protected $table = 'balance_history';
    protected $fillable = [
        'user_id',
        'value'
    ];
}
