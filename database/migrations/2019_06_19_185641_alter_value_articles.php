<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterValueArticles extends Migration
{
    public function up()
    {
        Schema::table('budget', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('budget', function (Blueprint $table) {
            $table->unsignedInteger('value')->default(0);
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
