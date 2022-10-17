<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportFormatToStockReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_reports', function (Blueprint $table) {
            $table->enum('report_format', ['Generic','Induk','Estate'])->default('Generic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_reports', function (Blueprint $table) {
            $table->dropColumn('report_format');
        });
    }
}
