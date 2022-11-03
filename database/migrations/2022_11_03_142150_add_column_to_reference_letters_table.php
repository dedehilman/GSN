<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReferenceLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reference_letters', function (Blueprint $table) {
            $table->string('physical_check')->nullable();
            $table->string('therapy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reference_letters', function (Blueprint $table) {
            $table->dropColumn('physical_check');
            $table->dropColumn('therapy');
        });
    }
}
