<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use App\Models\FinancialResource;
use App\Models\Target;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $viewData = [
            'rates' => CurrencyRate::all()
        ];

        if(auth()->check()){
            $template = 'home';
            $resources = FinancialResource::where('user_id',auth()->id())
                ->orderBy('currency_id')
                ->orderBy('name')
                ->get();

            $viewData['totalInMDL'] = User::getBalanceInMainCurrency(auth()->id());
            $viewData['target'] = Target::where('user_id',auth()->id())->first();
            $viewData['resources'] = $resources;
            $viewData['transactions'] = Transaction::where('user_id',auth()->id())
                ->limit(20)
                ->orderByDesc('created_at')
                ->get();
        } else {
            $template = 'welcome';
        }

        return view($template, $viewData);
    }

    public function createTarget(Request $request){

        $existingTarget = Target::where('user_id',auth()->id())->first();
        DB::beginTransaction();
        try {
            if($existingTarget){
                $existingTarget->update(['value' => $request->get('value')]);
            } else {
                Target::create([
                    'user_id' => auth()->id(),
                    'value' => $request->get('value'),
                ]);
            }

            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes', ['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function updateRates(){
        Artisan::call('get_rates');
        Artisan::call('get_cripto_rate', [
            'name' => 'ethereum', 'code' => 'ETH'
        ]);
        Artisan::call('get_cripto_rate', [
            'name' => 'bitcoin', 'code' => 'BTC'
        ]);
        return redirect()->back();
    }
}
