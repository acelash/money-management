<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransactions extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('currency_id');
            $table->integer('resource_id');
            $table->smallInteger('is_passive_income')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('currency_id');
            $table->dropColumn('resource_id');
            $table->dropColumn('is_passive_income');
        });
    }
}
