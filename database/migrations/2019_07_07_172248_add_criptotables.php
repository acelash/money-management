<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCriptotables extends Migration
{
    public function up()
    {
        Schema::create('cripto_resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('currency_id');
            $table->string('name',150);
            $table->timestamps();
        });

        Schema::create('cripto_investitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('resource_id');
            $table->string('comment',180)->nullable();
            $table->float('investition_value',15,7);
            $table->float('ammount_purchased',15,7);
            $table->timestamps();
        });

        if(Schema::hasColumn('currency_rates', 'rate')){
            Schema::table('currency_rates', function (Blueprint $table) {
                $table->dropColumn('rate');
            });
        }
        Schema::table('currency_rates', function (Blueprint $table) {
            $table->float('rate',15,7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cripto_resources');
        Schema::dropIfExists('cripto_investitions');
    }
}
