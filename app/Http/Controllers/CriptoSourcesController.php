<?php

namespace App\Http\Controllers;

use App\Models\CriptoInvestition;
use App\Models\CriptoResource;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriptoSourcesController extends Controller
{
    public function index()
    {
        $resources = CriptoResource::where('user_id',auth()->id())
        ->orderBy('currency_id')
        ->orderBy('name')
        ->get();

        $finances = [];

        foreach ($resources as $resource){
            if(isset($finances[$resource->currency_id])){
                $finances[$resource->currency_id]['total'] += $resource->amount->sum('ammount_purchased');
            } else {
                $finances[$resource->currency_id] = [
                    'code' =>$resource->currency->code,
                    'total' =>$resource->amount->sum('ammount_purchased')
                ];
            }
        }
        $viewData = [
            'rates' => CurrencyRate::all(),
            'currencies' => Currency::all(),
            'resources' => $resources,
            'totalInMDL' => User::getCriptoBalanceInMainCurrency(auth()->id()),
            'finances' => $finances,
            'investitions' => CriptoInvestition::where('user_id',auth()->id())->orderBy('created_at','DESC')->get()
        ];


        $currentValue = 0;

        foreach ($viewData['investitions'] as $investition){
            $currentValue += $investition->getProfitRate() * $investition->investition_value;
        }

        $overview = [
            'total_invested' => $viewData['investitions']->sum('investition_value'),
            'investition_worth' => $currentValue
        ];

        $viewData['overview'] = $overview;
        return view('cripto-sources', $viewData);
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|max:140',
            'currency_id' => 'required',
        ]);

        $data = [
            'name' => $request->get('name'),
            'currency_id' => $request->get('currency_id'),
            'user_id' => auth()->id(),
        ];

        DB::beginTransaction();
        try {
            CriptoResource::create($data);
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
        ]);

        $id = $this->request->get('resource_id');

        $entity = CriptoResource::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        $data = [
            'name' => $this->request->get('name'),
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
        CriptoResource::where('id',$id)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        if (CriptoResource::destroy($id)) {
            return redirect()->back()->with(["success" => true, "message" => trans('translate.removed')]);
        } else {
            return redirect()->back()->with(["success" => false, "message" => trans('translate.error')]);
        }
    }

    public function loadResourceData($id){
        $entity = CriptoResource::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        return [
            'success' => true,
            'item' => $entity->toArray()
        ];
    }
}
