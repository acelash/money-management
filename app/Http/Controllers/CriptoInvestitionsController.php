<?php

namespace App\Http\Controllers;

use App\Models\CriptoInvestition;
use App\Models\CriptoResource;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriptoInvestitionsController extends Controller
{
    public function index()
    {
        $transactions = CriptoInvestition::where('user_id',auth()->id())
            ->orderByDesc('created_at')
            ->paginate(30);

        $resources = CriptoResource::where('user_id',auth()->id())
            ->orderBy('currency_id')
            ->orderBy('name')
            ->get();
        $totalInMDL = 0;
        foreach ($resources as $resource){
            if($resource->currency_id == 1){
                $totalInMDL += $resource->value;
            } else {
                $totalInMDL += $resource->value * $resource->currency->rate->rate;
            }
        }

        $viewData = [
            'rates' => CurrencyRate::all(),
            'currencies' => Currency::all(),
            'resources' => $resources,
            'transactions' => $transactions,
            'totalInMDL' => $totalInMDL,
        ];

        return view('transactions', $viewData);
    }

    public function create(Request $request)
    {
        $request->validate([
            'ammount_purchased' => 'required',
            'resource_id' => 'required',
            'investition_value' => 'required',
        ]);

        $data = [
            'comment' => " ",
            'investition_value' => $request->get('investition_value'),
            'resource_id' => $request->get('resource_id'),
            'ammount_purchased' => $request->get('ammount_purchased'),
            'user_id' => auth()->id(),
        ];


        DB::beginTransaction();
        try {
            CriptoInvestition::create($data);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes', ['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            CriptoInvestition::destroy($id);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => trans('translate.removed')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
