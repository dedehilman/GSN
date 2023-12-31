<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkAccidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_accidents', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->date('transaction_date');
            $table->enum('reference_type', ['NonReference', 'Internal', 'External'])->default('Internal');
            $table->unsignedBigInteger('reference_clinic_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('medical_staff_id');
            $table->unsignedBigInteger('patient_id');
            $table->tinyInteger('for_relationship')->default(0);
            $table->unsignedBigInteger('patient_relationship_id')->nullable();
            $table->unsignedBigInteger('work_accident_category_id')->nullable();
            $table->unsignedBigInteger('exposure_id')->nullable();
            $table->datetime('accident_date')->nullable();
            $table->string('accident_location')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('medical_staff_id')->references('id')->on('medical_staff')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('patient_relationship_id')->references('id')->on('employee_relationships')->onDelete('cascade');
            $table->foreign('work_accident_category_id')->references('id')->on('work_accident_categories')->onDelete('cascade');
            $table->foreign('reference_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('reference_id')->references('id')->on('references')->onDelete('cascade');
            $table->foreign('exposure_id')->references('id')->on('exposures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_accidents');
    }
}
