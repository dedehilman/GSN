<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameUploadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_uploaders', function (Blueprint $table) {
            $table->id();
            $table->string('upl_no');
            $table->integer('upl_line_no');
            $table->string('upl_remark')->nullable();
            $table->enum('upl_status', [0,1,2,3,4])->default(0);
            
            $table->string('period')->nullable();
            $table->string('medicine')->nullable();
            $table->string('clinic')->nullable();
            $table->string('qty')->nullable();

            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_opname_uploaders');
    }
}
