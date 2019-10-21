<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableCurrencyRate extends Migration
{
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('currency_id');
            $table->float('rate',8,4)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
}
