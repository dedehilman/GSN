<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentHistoryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_history_reports', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('file_path')->nullable();
            $table->string('message')->nullable();
            $table->integer('num_of_downloaded')->default(0);
            $table->datetime('runned_at')->nullable();
            $table->datetime('finished_at')->nullable();
            $table->enum('status', [0,1,2,3])->default(0);
            $table->unsignedBigInteger('patient_id');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatment_history_reports');
    }
}
