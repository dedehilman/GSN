<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_plannings', function (Blueprint $table) {
            $table->enum('status', ["Draft", "Publish", "Cancelled"])->default("Draft");
        });
        Schema::table('outpatients', function (Blueprint $table) {
            $table->enum('status', ["Draft", "Publish", "Cancelled"])->default("Draft");
        });
        Schema::table('plano_tests', function (Blueprint $table) {
            $table->enum('status', ["Draft", "Publish", "Cancelled"])->default("Draft");
        });
        Schema::table('work_accidents', function (Blueprint $table) {
            $table->enum('status', ["Draft", "Publish", "Cancelled"])->default("Draft");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('family_plannings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('outpatients', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('plano_tests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('work_accidents', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
