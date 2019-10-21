<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RmFloatFields extends Migration
{
    public function up()
    {
        if(Schema::hasColumn('transactions', 'value')){
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('value');
            });
        }

        Schema::table('transactions', function (Blueprint $table) {
            $table->float('value',12,2);
        });

        if(Schema::hasColumn('financial_resources', 'value')){
            Schema::table('financial_resources', function (Blueprint $table) {
                $table->dropColumn('value');
            });
        }
        Schema::table('financial_resources', function (Blueprint $table) {
            $table->float('value',12,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
