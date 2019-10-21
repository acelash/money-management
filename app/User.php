<?php

namespace App;

use App\Models\CriptoInvestition;
use App\Models\Currency;
use App\Models\FinancialResource;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getBalanceInMainCurrency(int $id):int {
        $resources = FinancialResource::where('user_id',$id)->get();
        $totalInMDL = 0;
        foreach ($resources as $resource){
            if($resource->currency_id == 1){
                $totalInMDL += $resource->value;
            } else {
                $totalInMDL += $resource->value * $resource->currency->rate->rate;
            }
        }
        return $totalInMDL;
    }

    public static function getCriptoBalanceInMainCurrency(int $id):int {
        $investitions = CriptoInvestition::where('user_id',$id)->get();
        $totalInMDL = 0;
        $usdToMDL = Currency::where('id',4)->first()->rate->rate;
        foreach ($investitions as $investition){
            $totalInMDL += $investition->ammount_purchased * $investition->resource->currency->rate->rate * $usdToMDL;
        }
        return $totalInMDL;
    }
}
