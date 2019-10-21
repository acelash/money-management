<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index()
    {
        $articles = Budget::where('user_id',auth()->id())
        ->orderBy('created_at')
        ->get();
        $montlyBudget = 0;

        foreach ($articles as $article){
            if($article->currency_id == 1){
                $montlyBudget += $article->value;
            } else {
                $montlyBudget += $article->value * $article->currency->rate->rate;
            }
        }

        $viewData = [
            'rates' => CurrencyRate::all(),
            'currencies' => Currency::all(),
            'articles' => $articles,
            'montlyBudget' => $montlyBudget,
        ];

        return view('budget', $viewData);
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
            Budget::create($data);
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
            'article_id' => 'required',
            'value' => 'required',
        ]);

        $id = $this->request->get('article_id');

        $article = Budget::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        $data = [
            'name' => $this->request->get('name'),
            'value' => $this->request->get('value'),
            'currency_id' => $this->request->get('currency_id'),
        ];

        DB::beginTransaction();
        try {
            $article->update($data);
            DB::commit();
            return redirect()->back()->with(["success" => true, "message" => __('messages.au-fost-salvate-cu-succes',['object' => ''])]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(["success" => false, "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $entry = Budget::where('id',$id)
            ->where('user_id',auth()->id())
            ->firstOrFail();

        if (Budget::destroy($id)) {
            return redirect()->back()->with(["success" => true, "message" => trans('translate.removed')]);
        } else {
            return redirect()->back()->with(["success" => false, "message" => trans('translate.error')]);
        }
    }

    public function loadArticleData($id){
        $article = Budget::where('user_id',auth()->id())
            ->where('id',$id)
            ->firstOrFail();

        return [
            'success' => true,
            'article' => $article->toArray()
        ];
    }
}
