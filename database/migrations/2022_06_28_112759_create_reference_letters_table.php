<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_letters', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->date('transaction_date');
            $table->string('remark')->nullable();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('medical_staff_id');
            $table->unsignedBigInteger('patient_id');
            $table->enum('reference_type', ['Internal', 'External'])->default('Internal');
            $table->unsignedBigInteger('reference_clinic_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->bigInteger('model_reference_id')->nullable();
            $table->string('model_reference_type')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('medical_staff_id')->references('id')->on('medical_staff')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('reference_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('reference_id')->references('id')->on('references')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reference_letters');
    }
}
