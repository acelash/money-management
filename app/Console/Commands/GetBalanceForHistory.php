<?php

namespace App\Console\Commands;

use App\Models\BalanceHistory;
use App\User;
use Illuminate\Console\Command;

class GetBalanceForHistory extends Command
{
    protected $signature = 'get_balance';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user){
            $balance = User::getBalanceInMainCurrency($user->id);
            BalanceHistory::create([
                'user_id' => $user->id,
                'value' => $balance
            ]);
        }
    }
}
