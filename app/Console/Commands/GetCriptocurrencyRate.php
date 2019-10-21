<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Console\Command;

class GetCriptocurrencyRate extends Command
{
    protected $signature = 'get_cripto_rate {name} {code}';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $url = "https://api.coinmarketcap.com/v1/ticker/".$this->argument('name')."/";
        $json = json_decode(file_get_contents($url),true);

        $currency = Currency::where('code',$this->argument('code'))->firstOrFail();
        $currencyRate = CurrencyRate::where('currency_id',$currency->id)->first();
        $currencyRate->update(['rate' => $json[0]['price_usd']]);
    }
}
