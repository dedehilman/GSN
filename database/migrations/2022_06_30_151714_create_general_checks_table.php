<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_checks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_reference_id')->nullable();
            $table->string('model_reference_type')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('blood_type')->nullable();
            $table->tinyInteger('color_blind')->default(0);
            $table->tinyInteger('disability')->default(0);
            $table->decimal('temperature', 5,2)->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('general_checks');
    }
}
