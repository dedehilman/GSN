<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisSymptomResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_symptom_results', function (Blueprint $table) {
            $table->unsignedBigInteger('diagnosis_id');
            $table->unsignedBigInteger('symptom_id');
            
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
            $table->foreign('symptom_id')->references('id')->on('symptoms')->onDelete('cascade');
            $table->primary(['diagnosis_id', 'symptom_id'], 'diagnosis_symptoms_result_id_primary'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosis_symptom_results');
    }
}
