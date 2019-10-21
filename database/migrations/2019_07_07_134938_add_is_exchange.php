<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsExchange extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->smallInteger('is_exchange')->nullable();
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
            $table->dropColumn('is_exchange');
        });
    }
}
