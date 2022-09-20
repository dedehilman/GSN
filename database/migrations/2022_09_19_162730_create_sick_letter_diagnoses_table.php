<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSickLetterDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sick_letter_diagnoses', function (Blueprint $table) {
            $table->unsignedBigInteger('diagnosis_id');
            $table->unsignedBigInteger('sick_letter_id');
            
            $table->foreign('sick_letter_id')->references('id')->on('sick_letters')->onDelete('cascade');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
            $table->primary(['sick_letter_id', 'diagnosis_id'], 'sick_letter_diagnosis_id_primary'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sick_letter_diagnoses');
    }
}
