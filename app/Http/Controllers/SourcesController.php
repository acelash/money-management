<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\FinancialResource;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SourcesController extends Controller
{
    public function index()
    {
        $resources = FinancialResource::where('user_id',auth()->id())
        ->orderBy('currency_id')
        ->orderBy('name')
        ->get();

        $finances = [];


        foreach ($resources as $resource){
            if(isset($finances[$resource->currency_id])){
                $finances[$resource->currency_id]['total'] += $resource->value;
            } else {
                $finances[$resource->currency_id] = [
                    'code' =>$resource->currency->code,
                    'total' =>$resource->value
                ];
            }
        }
        $viewData = [
            'rates' => CurrencyRate::all(),
            'currencies' => Currency::all(),
            'resources' => $resources,
            'totalInMDL' => User::getBalanceInMainCurrency(auth()->id()),
            'finances' => $finances,
        ];

        return view('sources', $viewData);
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|max:140',
            'currency_id' => 'required',
            'value' => 'required',
        ]);

        $data = [
            'name' => $request->get('name'),
            'value' => $request->get('value'),
            'currency_id' => $request->get('currency_id'),
            'user_id' => auth()->id(),
        ];

        DB::beginTransaction();
        try {
            FinancialResource::create($data);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes',['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function update(){
        $this->request->validate([
            'name' => 'required|max:140',
            'currency_id' => 'required',
            'resource_id' => 'required',
            'value' => 'required',
        ]);

        $id = $this->request->get('resource_id');

        $entity = FinancialResource::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        $data = [
            'name' => $this->request->get('name'),
            'value' => $this->request->get('value'),
            'currency_id' => $this->request->get('currency_id'),
        ];

        DB::beginTransaction();
        try {
            $entity->update($data);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes',['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        FinancialResource::where('id',$id)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        DB::beginTransaction();
        try {
            FinancialResource::destroy($id);
            Transaction::where('resource_id',$id)->delete();
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => trans('translate.removed')]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(["success" => false, "message" => trans('translate.error')]);
        }
    }

    public function loadResourceData($id){
        $entity = FinancialResource::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        return [
            'success' => true,
            'item' => $entity->toArray()
        ];
    }
}
