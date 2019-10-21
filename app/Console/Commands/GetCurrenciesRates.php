<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Console\Command;

class GetCurrenciesRates extends Command
{
    protected $signature = 'get_rates';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $url = "http://bnm.md/md/official_exchange_rates?get_xml=1&date=".date('d.m.Y');
        $xml = simplexml_load_file($url); //retrieve URL and parse XML content

        if(!$xml) throw new \Error("Unable to get xml file");

        $currencyCodes = Currency::all()->pluck('code')->toArray();
        $currency2 = Currency::where('code','MDL')->firstOrFail();

        foreach ($xml->Valute as $xmlCurrency){
            if(in_array($xmlCurrency->CharCode,$currencyCodes)){
                $currency = Currency::where('code',$xmlCurrency->CharCode)->firstOrFail();
                $currencyRate = CurrencyRate::where('currency_id',$currency->id)->first();
                if($currencyRate){
                    $currencyRate->update(['rate'=>$xmlCurrency->Value]);
                } else {
                    CurrencyRate::create([
                        'currency_id' => $currency->id,
                        'currency2_id' => $currency2->id,
                        'rate'=>$xmlCurrency->Value
                    ]);
                }
            }
        }
    }
}
