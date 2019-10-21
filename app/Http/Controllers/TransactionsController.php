<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\FinancialResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id',auth()->id())
            ->orderByDesc('created_at')
            ->paginate(30);

        $resources = FinancialResource::where('user_id',auth()->id())
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
            'comment' => 'required|max:170',
            'type' => 'required',
            'resource_id' => 'required',
            'value' => 'required',
        ]);

        $data = [
            'comment' => $request->get('comment'),
            'is_passive_income' => $request->get('is_passive_income'),
            'is_exchange' => $request->get('is_exchange'),
            'value' => $request->get('value'),
            'resource_id' => $request->get('resource_id'),
            'type' => $request->get('type'),
            'user_id' => auth()->id(),
        ];

        $resource = FinancialResource::where('user_id', auth()->id())
            ->where('id', $request->get('resource_id'))
            ->firstOrFail();

        if ($request->get('type') == config('constants.TRANSACTION_TYPES.IN')) {
            $newResourceValue = $resource->value + $request->get('value');
        } else {
            $newResourceValue = $resource->value - $request->get('value');
        }

        if($newResourceValue < 0) return
            redirect()->back()->withInput()->with(["success" => false, "message" => "No sufficient funds for this transaction (".$resource->value.")"]);

        DB::beginTransaction();
        try {
            Transaction::create($data);
            $resource->update([
                'value' => $newResourceValue
            ]);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes', ['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $resource = FinancialResource::where('user_id', auth()->id())
            ->where('id', $transaction->resource_id)
            ->firstOrFail();

        if ($transaction->type == config('constants.TRANSACTION_TYPES.IN')) {
            $newResourceValue = $resource->value - $transaction->value;
        } else {
            $newResourceValue = $resource->value + $transaction->value;
        }

        if($newResourceValue < 0) return
            redirect()->back()->withInput()->with(["success" => false, "message" => "Can't remove this transaction: no enough funds on the resource (".$resource->value.")"]);


        DB::beginTransaction();
        try {
            Transaction::destroy($id);
            $resource->update([
                'value' => $newResourceValue
            ]);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => trans('translate.removed')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }
}
