<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicAfdelinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_afdelinks', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('afdelink_id');
            
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('afdelink_id')->references('id')->on('afdelinks')->onDelete('cascade');
            $table->primary(['clinic_id', 'afdelink_id'], 'clinic_afdelinks_id_primary'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_afdelinks');
    }
}
