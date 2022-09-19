<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('work_unit_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();

            $table->foreign('work_unit_id')->references('id')->on('work_units')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
