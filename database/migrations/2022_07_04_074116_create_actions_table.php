<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_reference_id')->nullable();
            $table->string('model_reference_type')->nullable();
            $table->enum('action', ['Finished', 'Re-Medicate', 'Refer']);
            $table->string('remark')->nullable();
            $table->enum('reference_type', ['Internal', 'External'])->default('Internal');
            $table->unsignedBigInteger('reference_clinic_id')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->date('remedicate_date')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('actions');
    }
}
