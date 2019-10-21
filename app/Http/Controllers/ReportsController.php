<?php

namespace App\Http\Controllers;

use App\Models\BalanceHistory;
use App\Models\CurrencyRate;
use App\Models\FinancialResource;
use App\Models\Transaction;
use App\User;

class ReportsController extends Controller
{
    public function index()
    {
        $viewData = [
            'rates' => CurrencyRate::all(),
            'reportIncomeExpenses' => $this->getReportIncomeExpenses(),
            'reportPassiveIncome' => $this->getReportPassiveIncome(),
            'reportPassiveIncomeToExpenses' => $this->getReportPassiveIncomeToExpenses(),
            'reportBalance' => $this->getReportBalance(),
            'totalInMDL' => User::getBalanceInMainCurrency(auth()->id()),
            'resources' => FinancialResource::where('user_id', auth()->id())
                ->orderBy('currency_id')
                ->orderBy('name')
                ->get()
        ];

        return view('reports', $viewData);
    }

    private function getReportIncomeExpenses()
    {
        $report = [
            'labels' => [],
            'dataIncome' => [],
            'dataExpenses' => [],
        ];
        for ($i = 5; $i >= 0; $i--) {
            $date = today();
            if ($i) $date->subMonths($i);

            // income
            $incomeTransactions = Transaction::where('user_id', auth()->id())
                ->where('type', config('constants.TRANSACTION_TYPES.IN'))
                ->whereNull('is_exchange')
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $income = 0;
            foreach ($incomeTransactions as $transaction) {
                if ($transaction->resource->currency_id == 1) {
                    $income += $transaction->value;
                } else {
                    $income += $transaction->value * $transaction->resource->currency->rate->rate;
                }
            }
            $report['dataIncome'][] = ceil($income);

            // expenses
            $outTransactions = Transaction::where('user_id', auth()->id())
                ->where('type', config('constants.TRANSACTION_TYPES.OUT'))
                ->whereNull('is_exchange')
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $expenses = 0;
            foreach ($outTransactions as $transaction) {
                if ($transaction->resource->currency_id == 1) {
                    $expenses += $transaction->value;
                } else {
                    $expenses += $transaction->value * $transaction->resource->currency->rate->rate;
                }
            }
            $report['dataExpenses'][] = ceil($expenses);

            $report['labels'][] = $date->format('F');
        }

        return $report;
    }

    private function getReportPassiveIncome()
    {
        $report = [
            'labels' => [],
            'dataIncome' => []
        ];
        for ($i = 5; $i >= 0; $i--) {
            $date = today();
            if ($i) $date->subMonths($i);

            // income
            $incomeTransactions = Transaction::where('user_id', auth()->id())
                ->where('type', config('constants.TRANSACTION_TYPES.IN'))
                ->where('is_passive_income', 1)
                ->whereNull('is_exchange')
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $income = 0;
            foreach ($incomeTransactions as $transaction) {
                if ($transaction->resource->currency_id == 1) {
                    $income += $transaction->value;
                } else {
                    $income += $transaction->value * $transaction->resource->currency->rate->rate;
                }
            }
            $report['dataIncome'][] = ceil($income);
            $report['labels'][] = $date->format('F');
        }

        return $report;
    }

    private function getReportPassiveIncomeToExpenses()
    {
        $report = [
            'labels' => [],
            'dataIncome' => []
        ];
        for ($i = 5; $i >= 0; $i--) {
            $date = today();
            if ($i) $date->subMonths($i);

            // passive income
            $incomeTransactions = Transaction::where('user_id', auth()->id())
                ->where('type', config('constants.TRANSACTION_TYPES.IN'))
                ->whereNull('is_exchange')
                ->where('is_passive_income', 1)
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $income = 0;
            foreach ($incomeTransactions as $transaction) {
                if ($transaction->resource->currency_id == 1) {
                    $income += $transaction->value;
                } else {
                    $income += $transaction->value * $transaction->resource->currency->rate->rate;
                }
            }

            // expenses
            $outTransactions = Transaction::where('user_id', auth()->id())
                ->where('type', config('constants.TRANSACTION_TYPES.OUT'))
                ->whereNull('is_exchange')
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $expenses = 0;
            foreach ($outTransactions as $transaction) {
                if ($transaction->resource->currency_id == 1) {
                    $expenses += $transaction->value;
                } else {
                    $expenses += $transaction->value * $transaction->resource->currency->rate->rate;
                }
            }

            if ($expenses == 0) $expenses = 1;

            $report['dataIncome'][] = ceil($income / $expenses * 100);
            $report['labels'][] = $date->format('F');
        }

        return $report;
    }

    private function getReportBalance(){
        $report = [
            'labels' => [],
            'data' => [],
        ];
        for ($i = 5; $i >= 0; $i--) {
            $date = today();
            if ($i) $date->subMonths($i);

            // income
            $balanceHistory = BalanceHistory::where('user_id', auth()->id())
                ->whereDate('created_at', '>=', $date->startOfMonth())
                ->whereDate('created_at', '<=', $date->endOfMonth())
                ->get();

            $balanceAverage = $balanceHistory->sum('value') / ($balanceHistory->count() ?: 1);

            $report['data'][] = ceil($balanceAverage);
            $report['labels'][] = $date->format('F');
        }

        return $report;
    }
}
